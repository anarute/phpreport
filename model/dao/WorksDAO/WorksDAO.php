<?php

/** File for WorksDAO
 *
 *  This file just contains {@link WorksDAO}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage DAO
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

include_once('phpreport/model/dao/BaseRelationshipDAO.php');

/** DAO for relationship Works
 *
 *  This is the base class for all types of relationship Works DAOs responsible for working with data from tables related to that
 *  relationship (User, Project and Works), providing a common interface. <br><br>Its edges are:
 * - A: User
 * - B: Project
 *
 * @see DAOFactory::getWorksDAO(), UserDAO, UserGroupDAO, UserVO, UserGroupVO
 */
abstract class WorksDAO extends BaseRelationshipDAO{

    /** Works DAO constructor.
     *
     * This is the base constructor of Works DAOs, and it just calls its parent's constructor.
     *
     * @throws {@link ConnectionErrorException}
     * @see BaseDAO::__construct()
     */
    function __construct() {
    parent::__construct();
    }

    /** Works entry retriever by id's.
     *
     * This function retrieves the row from Works table with the id's <var>$userId</var> and <var>$projectId</var>.
     *
     * @param int $userId the id (that matches with a User) of the row we want to retrieve.
     * @param int $projectId the id (that matches with a Project) of the row we want to retrieve.
     * @return array an associative array with the data of the row.
     * @throws {@link OperationErrorException}
     */
    protected abstract function getByIds($userId, $projectId);

    /** Projects retriever by User id.
     *
     * This function retrieves the rows from Project table that are assigned through relationship Works to the User with
     * the id <var>$userId</var> and creates a {@link ProjectVO} with data from each row.
     *
     * @param int $userId the id of the User whose Projects we want to retrieve.
     * @return array an array with value objects {@link ProjectVO} with their properties set to the values from the rows
     * and ordered ascendantly by their database internal identifier.
     * @see UserDAO, ProjectDAO
     * @throws {@link OperationErrorException}
     */
    public abstract function getByUserId($userId);

    /** Users retriever by Project id.
     *
     * This function retrieves the rows from User table that are assigned through relationship Works to the Project with
     * the id <var>$projectId</var> and creates a {@link UserVO} with data from each row.
     *
     * @param int $projectId the id of the Project whose Users we want to retrieve.
     * @return array an array with value objects {@link UserVO} with their properties set to the values from the rows
     * and ordered ascendantly by their database internal identifier.
     * @see ProjectDAO, UserDAO
     * @throws {@link OperationErrorException}
     */
    public abstract function getByProjectId($projectId);

    /** Works relationship entry creator by User id and Project id.
     *
     * This function creates a new entry in the table Works
     * with the User id <var>$userId</var> and the Project id <var>$projectId</var>.
     *
     * @param int $userId the id of the User we want to relate to the Project.
     * @param int $projectId the id of the Project we want to relate to the User.
     * @return int the number of rows that have been affected (it should be 1).
     * @see UserDAO, ProjectDAO
     * @throws {@link OperationErrorException}
     */
    public abstract function create($userId, $projectId);

    /** Works relationship entry deleter by User id and Project id.
     *
     * This function deletes a entry in the table Works
     * with the User id <var>$userId</var> and the Project id <var>$projectId</var>.
     *
     * @param int $userId the id of the User whose relation to the Project we want to delete.
     * @param int $projectId the id of the Project whose relation to the User we want to delete.
     * @return int the number of rows that have been affected (it should be 1).
     * @see UserDAO, ProjectDAO
     * @throws {@link OperationErrorException}
     */
    public abstract function delete($userId, $projectId);

}
