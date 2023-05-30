<?php

namespace Drush\Commands;

class CustomHelloCommands extends DrushCommands {

  /**
   * Display "Hello world!".
   *
   * @command custom:hello-world
   * @aliases chw
   */
  public function helloWorld(): void {
    $this->output()->writeln('Hello world!');
  }

  /**
   * Display "Hello {name}".
   *
   * @param string $name
   *   Name of the primary person to greet.
   * @param string[] $others
   *   Names of other people to greet.
   *
   * @command custom:hello-human
   * @aliases chh
   * @option $informal Say "What up" instead of "Hello".
   * @usage custom:hello-human John Jane Gene
   */
  public function helloHuman(string $name, array $others): void {
    $names = array_merge([$name], $others);
    array_walk($names, [$this, 'validateName']);
    $this->logger()->info('{count} names received.', ['count' => count($names)]);

    $greeting = $this->input()->getOption('informal') ? 'What up' : 'Hello';
    $this->output()->writeln("$greeting $name.");

    if (!empty($others)) {
      $this->output()->writeln("Looks like you're not alone!");
      $this->output()->writeln("$greeting " . $this->join($others) . '.');
    }
  }

  private function join(array $items): string {
    $last = array_pop($items);
    if (empty($items)) {
      return $last;
    }

    if (count($items) === 1) {
      return reset($items) . ' and ' . $last;
    }

    return implode(', ', $items) . ', and ' . $last;
  }

  private function validateName(string $name): void {
    if (empty($name)) {
      throw new \Exception('Name cannot be empty.');
    }

    if (strlen($name) < 2) {
      throw new \Exception('Name must be at least 2 characters long.');
    }
  }

}
