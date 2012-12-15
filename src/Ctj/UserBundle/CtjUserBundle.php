<?php

namespace Ctj\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CtjUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
            
}
