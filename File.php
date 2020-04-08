<?php
    class File
    {
        protected $password='zdravko100';
        protected $file;
        protected $output;
        protected $current_path;
        protected $compiler_path;
        protected $compiler='g++';

        public $outputArray;

        public function __construct(string $file_name='nes',$output='nesto')
        {
            exec('pwd',$curr_path);
            $this->current_path= $curr_path[0];
            $this->file= $file_name;
            $this->output_file= $output;
        }
        public function execute()
        {
            //  object file doesn't exists
            if(!$this->checkIfExists())
            {
                $this->findCompiler();
                $this->makeExecutable();
                $this->run();
            }else {
                $this->findCompiler();
                $this->makeExecutable();
                $this->run();
            }
        }
        public function findCompiler()
        {
            exec('which '.$this->compiler,$out);
            $this->compiler_path= $out[0];
        }
        public function checkIfExists()
        {
            // $folder_files= glob(__DIR__.'/*');
            $folder_files=scandir($this->current_path);
            foreach($folder_files as $file)
            {
                if($file==$this->output_file)
                    return true;
            }
            return false;
        }
        public function makeExecutable()
        {
            $command= $this->compiler_path.' -o '.$this->output_file.' '.$this->file;
            exec($command,$output);
            return $output;
        }
        public function run()
        {
            $shell_path= './'.$this->output_file.' 1,3,5,7';
            // var_dump($shell_path) or die();
            exec($shell_path,$output_data);
            // var_dump($output_data) or die();
            $this->outputArray= $output_data;
            return $output_data;
        }
        public function getOutput()
        {
            return $this->outputArray;
        }        
    }

?>