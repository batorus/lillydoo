<?php

namespace LillydooBundle\Twig;

class LillydooExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('isfile', array($this, 'isFile')),
        );
    }
    
    public function isFile($item){
        if(is_file($item)){

          return true;
        }

        return false;
    }


    public function getName()
    {
        return 'lillydoo_extension';
    }
}