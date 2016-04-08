<?PHP

if(defined('MEMCACHE') == 1)
{
    echo 'const is exists:'.MEMCACHE;
}
else
{
    define('MEMCACHE','I am a Memcache');
    //echo MEMCACHE;
    //echo defined('MEMCACHE');

}
echo MEMCACHE;


?>