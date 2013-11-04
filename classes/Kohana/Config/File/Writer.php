<?php
/**
 * 配置文件写方法
 *
 * @author Liu.Jie <ljyf5593@gmail.com>
 *
 * @copyright  Copyright (c) 2013 Wuhan Bo Sheng Education Information Co., Ltd.
 */
class Kohana_Config_File_Writer extends Kohana_Config_File_Reader implements Kohana_Config_Writer {

    protected $_loaded_keys = array();

    /**
     * Tries to load the specificed configuration group
     *
     * Returns FALSE if group does not exist or an array if it does
     *
     * @param  string $group Configuration group
     * @return boolean|array
     */
    public function load($group)
    {
        $config = parent::load($group);

        if ($config !== FALSE)
        {
            $this->_loaded_keys[$group] = $config;
        }

        return $config;
    }

    /**
     * Writes the passed config for $group
     *
     * Returns chainable instance on success or throws
     * Kohana_Config_Exception on failure
     *
     * @param string      $group  The config group
     * @param string      $key    The config key to write to
     * @param array       $config The configuration to write
     * @return boolean
     */
    public function write($group, $key, $config)
    {
        $this->_loaded_keys[$group][$key] = $config;
        $config_file = APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$group.'.php';
        file_put_contents($config_file, "<?php\nreturn ".var_export($this->_loaded_keys[$group], TRUE).';');

        return TRUE;
    }
}