<?php

namespace Liuggio\StatsDClientBundle\Monolog\Formatter;

use Monolog\Formatter\LineFormatter;

/**
 * Formats incoming records into a one-line string
 *
 * This is especially useful for logging to files
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Christophe Coevoet <stof@notk.org>
 * @author Giulio De Donato <liuggio@gmail.com>
 */
class ShortLineFormatter extends LineFormatter
{
    const SIMPLE_FORMAT = "%channel%.%level_name%.%short_message%";

    protected $format;

    /**
     * @param string $format The format of the message
     */
    public function __construct($format = null)
    {
        $this->format = $format ? : static::SIMPLE_FORMAT;
        parent::__construct();
    }

    /**
     * this function convert a long message to 2 words message
     * eg. from: "Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\EventListener"
     *     to:    Notified event
     * @param $message
     * @todo find a cleaner function
     * @todo  add a function that removes the all the char different from [a-b A-Z]
     */
    public function getFirst2Words($message)
    {
        $pieces = explode(' ', $message);
        $shortMessage = '';
        if ($pieces && isset($pieces[0])) {
            $shortMessage = $pieces[0];
            if (isset($pieces[1])) {
                $shortMessage .= '*' . $pieces[1];
            }
        }

        $shortMessage = preg_replace("/[^A-Za-z0-9?![:space:]]/", "-", $shortMessage);

        return $shortMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $vars = parent::normalize($record);
        $output = $this->format;
        $vars['short_message'] = $this->getFirst2Words($vars['message']);
        foreach ($vars as $var => $val) {
            $output = str_replace('%' . $var . '%', $this->convertToString($val), $output);
        }
        return $output;
    }


}
