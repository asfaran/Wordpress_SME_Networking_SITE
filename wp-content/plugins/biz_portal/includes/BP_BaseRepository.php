<?php

class BP_BaseRepository
{
	/** 
	 * Wordpress db object
	 * @var wpdb $db 
	 */
    protected $db;
    
    /** 
     * Wordpress table prefix
     * @var string $prefix
     */
    protected $table_prefix;
    
    /**
     * @todo tobe removed
     * @var string
     */
    protected $prefix;

    /**
     * Table definitions
     * @var BP_TableDefinitions $table_def
     */
    protected $table_def;


	/**
     * Class constructor
     * 
     * @param wpdb $dbObject
     * @param string $table_prefix
     */
	public function __construct(wpdb $dbObject, $table_prefix)
	{
		$this->db = $dbObject;
		$this->table_prefix = $table_prefix;

        $this->table_def = new BP_TableDefinitions();
	}

	/**
     * Create table names prefixed with wordpress prefix
     * 
     * @param string $table_name
     * @throws \Exception
     * @return string
     */
    protected function get_table_name($table_name)
    {
        return $this->table_prefix . $table_name;
    }

    /**
     * Create comma seperated list of table columns
     * 
     * Create comma seperated list of table columns with the given prefix and alias to be
     * used in joined tabled easily.
     * 
     * @param string $table_name
     * @param string $alias
     * @param string $prefix
     * 
     * @return string
     */
    protected function get_prefixed_table_columns($table_name, $alias, $prefix = '')
    {
    	$columns = $this->db->get_results("SHOW COLUMNS FROM " . $this->get_table_name($table_name), ARRAY_A);
    	$columns_str = "";
    	foreach ($columns as $column) {    		
    		$columns_str .= $alias . '.' . $column['Field'] . ' AS ' . $prefix . $column['Field'] . ', ';
    	}
    	$columns_str = substr($columns_str, 0, -2);
    	return $columns_str;
    }

    /**
     * Crate and return the SQL string for selecting all fields
     *
     * @param string $table_name
     * @param array $where
     * @param array $format
     * @param int $count
     * @param int $offset
     * @return string
     */
    public function create_sql_select_all($table_name, array $where = array(), array $format = array(), $count = 0, $offset = 0)
    {
        $sql = "SELECT * FROM " . $this->get_table_name($table_name);
        $sql .= $this->create_partial_sql($where, $format, $count, $offset);

        $replace_values = array();
        if ($count > 0 && $offset > 0) {
            $sql .= " LIMIT %d, %d";
            $replace_values[] = $offset;
            $replace_values[] = $count;
        }
        elseif ($count > 0) {
            $sql .= " LIMIT %d";
            $replace_values[] = $count;
        }

        if (count($replace_values) > 0)
            $sql = vsprintf($sql, $replace_values);

        return $sql;
    }

    /**
     * Crate and return the SQL string for getting count value
     *
     * @param string $table_name
     * @param array $where
     * @param array $format
     * @return string
     */
    public function create_sql_select_count($table_name, array $where = array(), array $format = array())
    {
        $sql = "SELECT COUNT(*) FROM " . $this->get_table_name($table_name);
        $sql .= $this->create_partial_sql($where, $format, 0, 0);

        return $sql;
    }

    /**
     * Crate and return partial SQL starting from WHERE clause
     *
     * @param array $where
     * @param array $format if empty array it will be ignored
     * @param int $count
     * @param int $offset
     * @return string
     */
    public function create_partial_sql(array $where = array(), array $format = array(), $count = 0, $offset = 0)
    {
        $sql = '';
        $replace_values = array();
        $bool_format = count($format) > 0 ? true : false;
        if (count($where) > 0) {            
            $sql .= " WHERE";
            $loop = 0;
            foreach ($where as $key => $value)
            {
                if ($loop > 0) $sql .= " AND";

                if ($bool_format)
                {
                    $format_key = $format[$loop];
                    if ($format_key === "%s")
                        $format_key = "'%s'";

                    $replace_values[] = $value;
                    $sql .= " $key = " . $format_key;  
                }
                else 
                {
                    $sql .= " $key = '$value'";
                }
                $loop++;
            }
        }
        
        $sql = vsprintf($sql, $replace_values);

        return $sql;
    }

    /**
     * Map the result array to object properties using the Hydrator class
     *
     * @param string $object
     * @param array $result
     */
    public function map_result($object, array $result) 
    {
        $return_result = array();
        foreach ($result as $res)
        {
            if (array_key_exists($res['id'], $return_result))
                $obj = $return_result[$res['id']];
            else {
                $obj = new $object();          
                BP_Hydrator::hydrate($obj, $res);
            }

            $return_result[$res['id']] = $obj;
        }

        return $return_result;
    }
}