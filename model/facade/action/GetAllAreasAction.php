<?php

/** File for GetAllAreasAction
 *
 *  This file just contains {@link GetAllAreasAction}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

include_once('phpreport/model/facade/action/Action.php');
include_once('phpreport/model/dao/DAOFactory.php');


/** Get all Areas Action
 *
 *  This action is used for retrieving all Areas.
 *
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */
class GetAllAreasAction extends Action{

    /** GetAllAreasAction constructor.
     *
     * This is just the constructor of this action.
     */
    public function __construct() {
        $this->preActionParameter="GET_ALL_AREAS_PREACTION";
        $this->postActionParameter="GET_ALL_AREAS_POSTACTION";

    }

    /** Specific code execute.
     *
     * This is the function that contains the code that retrieves the Areas from persistent storing.
     *
     * @return array an array with value objects {@link UserVO} with their properties set to the values from the rows
     * and ordered ascendantly by their database internal identifier.
     */
    protected function doExecute() {

        $dao = DAOFactory::getAreaDAO();

        return $dao->getAll();

    }

}


//Test code;

/*$action= new GetAllAreasAction();
var_dump($action);
$result = $action->execute();
var_dump($result);
 */
