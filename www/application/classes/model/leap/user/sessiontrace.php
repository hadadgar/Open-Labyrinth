<?php
/**
 * Open Labyrinth [ http://www.openlabyrinth.ca ]
 *
 * Open Labyrinth is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Open Labyrinth is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Open Labyrinth.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright 2012 Open Labyrinth. All Rights Reserved.
 *
 */
defined('SYSPATH') or die('No direct script access.');

/**
 * Model for user_sessiontraces table in database 
 */
class Model_Leap_User_SessionTrace extends DB_ORM_Model {

    public function __construct() {
        parent::__construct();

        $this->fields = array(
            'id' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 11,
                'nullable' => FALSE,
            )),
            
            'session_id' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 10,
                'nullable' => FALSE,
                'unsigned' => TRUE,
            )),
            
            'user_id' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 10,
                'nullable' => FALSE,
                'unsigned' => TRUE,
            )),
            
            'map_id' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 10,
                'nullable' => FALSE,
                'unsigned' => TRUE,
            )),
            
            'node_id' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 10,
                'nullable' => FALSE,
                'unsigned' => TRUE,
            )),
            
            'counters' => new DB_ORM_Field_String($this, array(
                'max_length' => 700,
                'nullable' => FALSE,
                'savable' => TRUE,
            )),
            
            'date_stamp' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 20,
                'nullable' => FALSE,
            )),
            
            'confidence' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 6,
                'nullable' => FALSE,
            )),
            
            'dams' => new DB_ORM_Field_String($this, array(
                'max_length' => 700,
                'nullable' => FALSE,
                'savable' => TRUE,
            )),
            
            'bookmark_made' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 11,
                'nullable' => FALSE,
            )),
            
            'bookmark_used' => new DB_ORM_Field_Integer($this, array(
                'max_length' => 11,
                'nullable' => FALSE,
            )),
        );
        
        $this->relations = array(
            'node' => new DB_ORM_Relation_BelongsTo($this, array(
                'child_key' => array('node_id'),
                'parent_key' => array('id'),
                'parent_model' => 'map_node',
            )),
        );
    }

    public static function data_source() {
        return 'default';
    }

    public static function table() {
        return 'user_sessiontraces';
    }

    public static function primary_key() {
        return array('id');
    }
    
    public function createTrace($sessionId, $userId, $mapId, $nodeId) {
        $this->session_id= $sessionId;
        $this->user_id = $userId;
        $this->map_id = $mapId;
        $this->node_id = $nodeId;
        $this->date_stamp = time();
        
        $this->save();
    }
    
    public function getTopTraceBySessionId($sessionId) {
        $builder = DB_SQL::select('default')
                ->from($this->table())
                ->where('session_id', '=', $sessionId)
                ->order_by('id', 'DESC')
                ->limit(1);
        $result = $builder->query();
        
        if($result->is_loaded()) {
            return $result[0]['id'];
        }
        
        return NULL;
    }
    
    public function isExistBySessionAndNodeIDs($sessionId, $nodeId) {
        $builder = DB_SQL::select('default')
                ->from($this->table())
                ->where('session_id', '=', $sessionId, 'AND')
                ->where('node_id', '=', $nodeId);
        $result = $builder->query();
        
        if($result->is_loaded()) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function getCountTracks($sessionId, $nodeIDs) {
        if(count($nodeIDs) > 0) {
			$builder = DB_SQL::select('default')
					->from($this->table())
					->where('session_id', '=', $sessionId, 'AND')
					->where('node_id', 'IN', $nodeIDs);
			$result = $builder->query();
			
			if($result->is_loaded()) {
				return count($result);
			}
		}
        
        return NULL;
    }
    
    public function getCounterByIDs($sessionId, $mapId, $nodeId) {
        $builder = DB_SQL::select('default')
                ->from($this->table())
                ->where('session_id', '=', $sessionId, 'AND')
                ->where('map_id', '=', $mapId, 'AND')
                ->where('node_id', '=', $nodeId)
                ->limit(1);
        $result = $builder->query();
        
        if($result->is_loaded()) {
            return $result[0]['counters'];
        }
        
        return NULL;
    }
    
    public function updateCounter($sessionId, $mapId, $nodeId, $newCounters) {
        $builder = DB_ORM::update('user_sessionTrace')
                ->set('counters', $newCounters)
                ->where('session_id', '=', $sessionId, 'AND')
                ->where('map_id', '=', $mapId, 'AND')
                ->where('node_id', '=', $nodeId);
        $builder->execute();
    }
    
    public function getTraceBySessionID($sessionId) {
        $builder = DB_SQL::select('default')
                ->from($this->table())
                ->where('session_id', '=', $sessionId)
                ->order_by('id', 'ASC');
        $result = $builder->query();
        
        if($result->is_loaded()) {
            $traces = array();
            foreach($result as $record) {
                $traces[] = DB_ORM::model('user_sessionTrace', array((int)$record['id']));
            }
            
            return $traces;
        }
        
        return NULL;
    }
    
    public function getCountersValues($sessionId) {
        $traces = $this->getTraceBySessionID($sessionId);
        
        if($traces != NULL and count($traces) > 0) {
            $result = array();
            $i = 0;
            foreach($traces as $trace) {
                if($trace->counters != '') {
                    $counters = DB_ORM::model('map_counter')->getCountersByMap($trace->map_id);
                    if($counters != NULL and count($counters) > 0) {
                        $currentCountersState = $trace->counters;
                        $j = 0;
                        foreach($counters as $counter) {
                            $s = strpos($currentCountersState, '[CID=' . $counter->id . ',') + 1;
                            $tmp = substr($currentCountersState, $s, strlen($currentCountersState));
                            $e = strpos($tmp, ']') + 1;
                            $tmp = substr($tmp, 0, $e - 1);
                            $tmp = str_replace('CID=' . $counter->id . ',V=', '', $tmp);
                            $result[$counter->name][0] = $counter->name;
                            $result[$counter->name][2] = $counter->id;
                            if (is_numeric($tmp)) {
                                $thisCounter = $tmp;
                                $result[$counter->name][1][] = $thisCounter;
                            }
                            $j++;
                        }
                    }
                }
                $i++;
            }
            
            return $result;
        }
        
        return NULL;
    }
}

?>