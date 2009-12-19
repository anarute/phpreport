<?php

/** File for GetOpenTaskStoriesAction
 *
 *  This file just contains {@link GetOpenTaskStoriesAction}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage facade
 * @author Jorge López Fernández <jlopez@igalia.com>
 */

include_once('phpreport/model/facade/action/Action.php');
include_once('phpreport/model/dao/DAOFactory.php');

/** Get Open Task Stories Action
 *
 *  This action is used for retrieving open Task Stories.
 *
 * @package PhpReport
 * @subpackage facade
 * @author Jorge López Fernández <jlopez@igalia.com>
 */
class GetOpenTaskStoriesAction extends Action{

    /** Project Id
     *
     * This variable contains the optional parameter for retrieving only open Task Stories related to a Project.
     *
     * @var int
     */
    private $projectId;

    /** User Id
     *
     * This variable contains the optional parameter for retrieving only open Task Stories related to an User.
     *
     * @var int
     */
    private $userId;

    /** GetActiveTaskStoriesAction constructor.
     *
     * This is just the constructor of this action.
     *
     * @param int $userId optional parameter for filtering by User.
     * @param int $projectId optional parameter for filtering by Project.
     * @return array an array with value objects {@link TaskStoryVO} with their properties set to the values from the rows
     * and ordered ascendantly by their database internal identifier.
     */
    public function __construct($userId = NULL, $projectId = NULL) {

        $this->preActionParameter="GET_OPEN_TASK_STORIES_PREACTION";
        $this->postActionParameter="GET_OPEN_TASK_STORIES_POSTACTION";
        $this->userId = $userId;
        $this->projectId = $projectId;

    }

    /** Specific code execute.
     *
     * This is the function that contains the code that returns all Projects.
     *
     * @return array an array with all the existing Projects.
     */
    protected function doExecute() {

    $dao = DAOFactory::getTaskStoryDAO();

    return $dao->getOpen($this->userId, $this->projectId);

    }

}


/*//Test code;

$action= new GetOpenTaskStoriesAction();
//var_dump($action);
$result = $action->execute();
var_dump($result);*/
