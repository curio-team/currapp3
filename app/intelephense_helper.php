<?php

// Deze file zorgt dat onderstaande methodes op view()->extends()... binnen LiveWire geen error gooien.

namespace Illuminate\Contracts\View;
use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{
  public function extends();
  public function section();
}