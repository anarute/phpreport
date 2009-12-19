<?php

/** File for BaseDAO
 *
 *  This file just contains {@link BaseDAO}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage DAO
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

include_once('phpreport/util/ConfigurationParametersManager.php');
include_once('phpreport/model/dao/DAOFactory.php');
include_once('phpreport/util/DBConnectionErrorException.php');
include_once('phpreport/util/SQLQueryErrorException.php');

/** Base class for all simple DAOs
 *
 *  This class is extended by every DAO we create responsible for working with a single table matched to a value object, and it contains their most basic variables and functions.
 *
 * @package PhpReport
 * @subpackage DAO
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */
abstract class BaseDAO {

    /** The connection to DB.
     *
     * This variable contains the connection to the database, with the parameters read from <i>{@link config.php}</i>.
     *
     * @var resource
     * @see __construct()
     */
    protected $connect;

    /** Base constructor.
     *
     * This is the base constructor of all simple DAOs, and it just creates the connection with the parameters read from <i>{@link config.php}</i>, storing it in <var>{@link $connect}</var>.
     *
     * @see ConfigurationParametersManager, config.php
     * @throws {@link ConnectionErrorException}
     * @todo create the connection pool and remove the connection and its creation from {@link BaseDAO}.
     */
    protected function __construct() {

    $parameters[] = ConfigurationParametersManager::getParameter('DB_HOST');
    $parameters[] = ConfigurationParametersManager::getParameter('DB_PORT');
    $parameters[] = ConfigurationParametersManager::getParameter('DB_USER');
    $parameters[] = ConfigurationParametersManager::getParameter('DB_NAME');
    $parameters[] = ConfigurationParametersManager::getParameter('DB_PASSWORD');

    $connectionString = "host=$parameters[0] port=$parameters[1] user=$parameters[2] dbname=$parameters[3] password=$parameters[4]";

    $this->connect = pg_connect($connectionString);
     if ($this->connect == NULL) throw new DBConnectionErrorException($connectionString);

    pg_set_error_verbosity($this->connect, PGSQL_ERRORS_VERBOSE);

    }

    /** Value object constructor.
     *
     * This is the function that DAOs will use to create new value objects with data retrieved from database.
     *
     * @param array $row an array with the values from a row.
     * @return mixed a value object with its properties set to the values from <var>$row</var>.
     */
    abstract protected function setValues($row);

    /** SQL retrieving data sentences performer.
     *
     * This function executes the retrieving data sentence in <var>$sql</var> and calls the function {@link setValues()} in order to
     * create a value object with each row, and returning them in an array afterwards. It uses the connection stored in <var>{@link $connect}</var>.
     *
     * @param string $sql a simple SQL 'select' sentence as a string.
     * @return array an associative array of value objects created with the data retrieved with <var>$sql</var>.
     * @throws {@link SQLQueryErrorException}
     * @see setValues()
     */
    protected function execute($sql) {
        $res = @pg_query($this->connect, $sql);
    if ($res == NULL) throw new SQLQueryErrorException(pg_last_error());

        if(pg_num_rows($res) > 0) {
            for($i = 0; $i < pg_num_rows($res); $i++) {
                $row = @pg_fetch_array($res);
                $VO[$i] = $this->setValues($row);
            }
        }

    @pg_freeresult($res);

        return $VO;
    }

}
