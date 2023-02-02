<?php

namespace App;

class Console extends Color
{
    private static array $argv;
    private static array $commandNames;
    private static array $purposes;

    /**
     * User input will not be visible to them as they type in the console
     * @param $input
     * @return string
     */
    public static function secretInput($input): string{
        echo $input;
        if(PHP_OS == 'WINNT' || PHP_OS == 'WIN32'){
            $result = shell_exec('C:\Windows\system32\WindowsPowerShell\v1.0\powershell.exe -Command "$Password=Read-Host -assecurestring; $PlainPassword = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto([System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($Password));  echo $PlainPassword;"');
        }else{
            shell_exec('stty -echo');
            $result = fgets(fopen('php://stdin','r'));
            shell_exec('stty echo');
        }
        return $result;
    }

    /**
     * It takes an input from the user and returns the value of the input
     * @param string $input
     * @return string
     */
    public static function input(string $input): string{
        echo $input;
        return fgets(fopen('php://stdin','r'));
    }

    /**
     * If there are any arguments, it receives them and also executes a closure
     * @param string $commandName
     * @param \Closure $closure
     * @return Console
     */
    public static function command(string $commandName, \Closure $closure): Console
    {
        global $argv;
        self::$argv = $argv;
        self::$commandNames[] = $commandName;

        self::runCommand($commandName, $closure);
        self::destruct($argv);
        return new self();
    }

    /**
     * Get an explanation
     * @param string $purpose
     * @return Console
     */
    public static function purpose(string $purpose): Console{
        self::$purposes[] = $purpose;
        return new self();
    }

    /**
     * Takes the value of an argument
     * @param string $option
     * @return string
     */
    public static function option(string $option): string{
        $value = self::argumentsSeparatedBySpaces($option);
        return $value == '' ?
            (self::argumentsSeparatedByEquals($option) ?: self::error("\nErr: value for option `$option` not found.")) : $value;

    }

    /**
     * @param string $option
     * @return string
     */
    private static function argumentsSeparatedBySpaces(string $option): string {
        foreach (self::$argv as $key=>$arg) {
            if($arg == $option){
                return self::$argv[$key+1] ?? '';
            }
        }
        return '';
    }

    /**
     * @param string $option
     * @return string
     */
    private static function argumentsSeparatedByEquals(string $option): string {
        $result = array_values(preg_grep("/$option=/",self::$argv));
        return count($result) > 0 ? explode('=',$result[0])[1] : '';
    }

    /**
     * @param string $commandName
     * @param \Closure $closure
     * @return void
     */
    private static function runCommand(string $commandName, \Closure $closure): void
    {
        if (isset(self::$argv[1]) and self::$argv[1] == $commandName) {
            unset(self::$argv[0], self::$argv[1]);
            call_user_func($closure, func_get_args());
        }
    }

    /**
     * If the commands are not executed, display a list of commands after the script finishes
     * @param array $argv
     * @return void
     */
    private static function destruct(array $argv): void
    {
        if (count($argv) <= 1 or in_array($argv[1], ['help', '--help', '-h','--h']))
            register_shutdown_function(fn()=>self::showCommandNamesAndDescriptions());
    }

    /**
     * @return void
     */
    private static function showCommandNamesAndDescriptions(): void
    {
        foreach (self::$commandNames as $key=>$commandName){
            echo sprintf("[*] %s \t %s\n",$commandName,self::$purposes[$key]);
            unset(self::$commandNames[$key]);
        }
    }


    public function __destruct()
    {
        echo self::none();
    }
}