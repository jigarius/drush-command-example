<?php

namespace Drush\Commands;

class CustomCommands extends DrushCommands {

  /**
   * Display hello world.
   * 
   * @command custom:hello
   * @aliases ch
   */
  public function hello() {
    $this->output()->writeln('Hello world!');
  }

}
