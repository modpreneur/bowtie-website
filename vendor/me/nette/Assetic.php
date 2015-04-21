<?php

    namespace me;

    use Nette\Application\ApplicationException;
    use Nette\DI\CompilerExtension;
    use Nette\FileNotFoundException;



    class Assetic extends CompilerExtension
    {

        public $defaults = array(
            'source' => [],
            'path' => "/"
        );



        public function loadConfiguration()
        {
            $config = $this->getConfig($this->defaults);
            $builder = $this->getContainerBuilder();
        }


        public function afterCompile(\Nette\PhpGenerator\ClassType $class)
        {
            $config = $this->getConfig($this->defaults);
            $builder = $this->getContainerBuilder();

            $pi = pathinfo($config["path"]);

            // @todo - ??


            if(!is_dir($config["path"])){
                if (!mkdir($config["path"], 0777, true)) {
                    throw new ApplicationException("Directory " . $config["path"] . " could not be created.");
                }
            }

            foreach ($config["source"] as $s) {

                if (is_dir($s) || is_file($s)) {
                    $pi = pathinfo($s);
                    $this->copy($s, $config["path"] . DIRECTORY_SEPARATOR . $pi["basename"]);
                    continue;
                }
                throw new FileNotFoundException();
            }
        }



        protected function copy($src, $dst)
        {
            if(is_file($src)){
                $pi = pathinfo($src);
                copy($src, $dst);
            }

            if(is_dir($src)){
                @mkdir($dst);
                $dir = opendir($src);
                while (false !== ($file = readdir($dir))) {
                    if (($file != '.') && ($file != '..')) {
                        if (is_dir($src . DIRECTORY_SEPARATOR . $file)) {
                            $this->copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
                        } else {
                            copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
                        }
                    }
                }
                closedir($dir);
            }
        }

    }