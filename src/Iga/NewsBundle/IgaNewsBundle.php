<?php

namespace Iga\NewsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IgaNewsBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
