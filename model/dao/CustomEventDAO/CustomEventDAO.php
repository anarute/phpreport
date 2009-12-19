<?php

/** File for CustomEventDAO
 *
 *  This file just contains {@link CustomEventDAO}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage DAO
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

include_once('phpreport/model/vo/CustomEventVO.php');
include_once('phpreport/model/dao/BaseDAO.php');

/** DAO for Custom Events
 *
 *  This is the base class for all types of Custom Event DAOs responsible for working with data from Custom Event table, providing a common interface.
 *
 * @see DAOFactory::getCustomEventDAO(), CustomEventVO
 */
abstract class CustomEventDAO extends BaseDAO{

    /** Custom Event DAO constructor.
     *
     * This is the base constructor of Custom Event DAOs, and it just calls its parent's constructor.
     *
     * @throws {@link ConnectionErrorException}
     * @see BaseDAO::__construct()
     */
    protected function __construct() {
    parent::__construct();
    }

    /** Custom Event retriever by id.
     *
     * This function retrieves the row from Custom Event table with the id <var>$customEventId</var> and creates a {@link CustomEventVO} with its data.
     *
     * @param int $customEventId the id of the row we want to retrieve.
     * @return CustomEventVO a value object {@link CustomEventVO} with its properties set to the values from the row.
     * @throws {@link OperationErrorException}
     */
    public abstract function getById($customEventId);

    /** Custom Events retriever by User id.
     *
     * This function retrieves the rows from Custom Event table that are associated with the User with
     * the id <var>$userId</var> and creates a {@link CustomEventVO} with data from each row.
     *
     * @param int $userId the id of the User whose Custom Events we want to retrieve.
     * @return array an array with value objects {@link CustomEventVO} with their properties set to the values from the rows
     * and ordered ascendantly by their database internal identifier.
     * @throws {@link OperationErrorException}
     */
    public abstract function getByUserId($userId);

    /** Custom Events retriever.
     *
     * This function retrieves all rows from Custom Event table and creates a {@link CustomEventVO} with data from each row.
     *
     * @return array an array with value objects {@link CustomEventVO} with their properties set to the values from the rows
     * and ordered ascendantly by their database internal identifier.
     * @throws {@link OperationErrorException}
     */
    public abstract function getAll();

    /** Custom Event updater.
     *
     * This function updates the data of a Custom Event by its {@link CustomEventVO}.
     *
     * @param CustomEventVO $customEventVO the {@link CustomEventVO} with the data we want to update on database.
     * @return int the number of rows that have been affected (it should be 1).
     * @throws {@link OperationErrorException}, {@link SQLUniqueViolationException}
     */
    public abstract function update(CustomEventVO $customEventVO);

    /** Custom Event creator.
     *
     * This function creates a new row for a Custom Event by its {@link CustomEventVO}.
     * The internal id of <var>$customEventVO</var> will be set after its creation.
     *
     * @param CustomEventVO $customEventVO the {@link CustomEventVO} with the data we want to insert on database.
     * @return int the number of rows that have been affected (it should be 1).
     * @throws {@link OperationErrorException}, {@link SQLUniqueViolationException}
     */
    public abstract function create(CustomEventVO $customEventVO);

    /** Custom Event deleter.
     *
     * This function deletes the data of a Custom Event by its {@link CustomEventVO}.
     *
     * @param CustomEventVO $customEventVO the {@link CustomEventVO} with the data we want to delete from database.
     * @return int the number of rows that have been affected (it should be 1).
     * @throws {@link OperationErrorException}
     */
    public abstract function delete(CustomEventVO $customEventVO);

}
