<?php

use Dotenv\Dotenv;
class File
{
    protected $password='zdravko100';
    protected $file;
    protected $cpp_folder= __DIR__. '/../sources';
    protected $output;
    protected $current_path;
    protected $compiler_path;
    protected $compiler='g++';
    protected $environment;
    protected $config;
    public $outputArray;

    public function __construct(string $file_name='', string $output='')
    {
        $dotenv= Dotenv::createImmutable(__DIR__.'/../');
        $this->environment= $dotenv->load();
        $this->config= include(__DIR__.'./../config/executor.php');
        if(empty($this->config) || !is_array($this->config))
            throw new Exception('cannot find configuration file. There will be putted in config/executor.php');
        $this->config= array_merge($this->config, $this->environment);
        exec('pwd',$curr_path);
        $this->current_path= $curr_path[0];
        $this->file= $file_name;
        $this->output_file= $output;
        $this->setup();
    }

    public function setup()
    {
        $this->findCompiler();
        $this->loadCompilerPath();
        if(!empty($this->config('cpp_sources_folder')))
            $this->cpp_folder= $this->config('cpp_sources_folder');

        if(empty($this->file) && !empty($this->config('INPUT_FILE')))
            $this->file= $this->config('INPUT_FILE');

        // find if he has already extension or not
        strpos('.cpp',$this->file) && $this->file=$this->file . '.cpp';

        if(empty($this->output_file) && !empty($this->config('OUTPUT_EXECUTABLE')))
            $this->output_file= $this->config('OUTPUT_EXECUTABLE');
    }

    public function execute()
    {
        //  object file doesn't exists
        if(!$this->checkIfCppProgramExists())
            throw new Exception("Cpp file sources/$this->file not exists in sources folder");

        $this->makeExecutable();
        $this->run();
    }
    public function findCompiler()
    {
        if(empty($this->config('compilers')))
            throw new Exception('cannot find compiler');

        // take first compiler to use
        foreach($this->config('compilers') as $compiler) {
            exec('which'. $compiler, $out);
            if(is_array($out) && !empty($out)) {
                $this->compiler= $compiler;
                break;
            }
        }
    }
    protected function loadCompilerPath()
    {
        // $this->compiler= '';
        exec('which ' . $this->compiler, $out);
        if(!count($out) || !is_string($out[0]))
            throw new Exception('Cannot find compiler. Please install it');
        $this->compiler_path= $out[0];
    }
    public function checkIfCppProgramExists()
    {
        $path= realpath($this->cpp_folder);
        if($path== false || !is_dir($path))
            throw new Exception('Cannot find cpp path');
        $folder_files=scandir($this->cpp_folder);
        foreach($folder_files as $file) {
            if($file==$this->file)
                return true;
        }
        return false;
    }
    public function makeExecutable()
    {
        $fpi= realpath($this->cpp_folder) . '/' . $this->file;
        $fpo= realpath($this->cpp_folder) . '/' . $this->output_file;
        $command= $this->compiler_path.' -o '. $fpo . ' ' . $fpi;
        // print_r(realpath($this->cpp_folder));die();
        // print_r($this->file);die();
        // print_r('echo dev | sudo '. $command);die();
        exec('touch ' . realpath($this->cpp_folder) . '/' . $this->output_file);
        // die();
        // exec('echo dev | sudo '. $command,$output);
        exec($command, $output);
        return $output;
    }
    public function run()
    {
        // print_r($this->output_file);die();
        $shell_path= $this->output_file;
        if(!in_array($this->output_file, scandir($this->cpp_folder)))
            throw new Exception('Executable not maked');

        exec($this->cpp_folder . '/' . $shell_path,$output_data);
        $this->outputArray= $output_data;
        return $output_data;
    }
    public function getOutput()
    {
        return $this->outputArray;
    }

    public function config(string $variable)
    {
        if(!array_key_exists($variable, $this->config))
            return null;
        return $this->config[$variable];
    }
}

?>
