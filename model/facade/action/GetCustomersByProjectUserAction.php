<?php

/** File for GetCustomersByProjectUserAction
 *
 *  This file just contains {@link GetCustomersByProjectUserAction}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage facade
 * @author Jorge López Fernández <jlopez@igalia.com>
 */

include_once('phpreport/model/facade/action/Action.php');
include_once('phpreport/model/dao/DAOFactory.php');
include_once('phpreport/model/vo/UserVO.php');

/** Get Customers a User's Projects Action
 *
 *  This action is used for retrieving information about Customers of Projects done by a User. If no User is specified, it returns all Customers.
 *
 * @package PhpReport
 * @subpackage facade
 * @author Jorge López Fernández <jlopez@igalia.com>
 */
class GetCustomersByProjectUserAction extends Action{

    /** Active projects flag
     *
     * This variable contains the optional parameter for retrieving only data related to active Projects.
     *
     * @var bool
     */
    private $active;

    /** The User.
     *
     * This variable contains the User whose Projects' Customers we want to retrieve.
     *
     * @var UserVO
     */
    private $userVO;

    /** GetCustomersByProjectUserAction constructor.
     *
     * This is just the constructor of this action.
     *
     * @param UserVO $userVO the User whose Projects' Customers we want to retrieve.
     * @param bool $active optional parameter for obtaining only data related to active Projects (by default it returns all them).
     */
    public function __construct(UserVO $userVO = NULL, $active = False) {
        $this->userVO = $userVO;
    $this->active = $active;
        $this->preActionParameter="GET_CUSTOMERS_BY_PROJECT_USER_PREACTION";
        $this->postActionParameter="GET_CUSTOMERS_BY_PROJECT_USER_POSTACTION";

    }

    /** Specific code execute.
     *
     * This is the function that contains the code that returns the Customers.
     *
     * @return array an array with value objects {@link CustomerVO} with their properties set to the values from the rows
     * and ordered ascendantly by their database internal identifier.
     */
    protected function doExecute() {

    $dao = DAOFactory::getCustomerDAO();

    if (is_null($this->userVO))
        return $dao->getAll($this->active);
    else
    {
        return $dao->getByProjectUserLogin($this->userVO->getLogin(), $this->active);
    }

    }

}


/*//Test code;

$user = new UserVO();

$user->setLogin("jaragunde");

$action= new GetCustomersByProjectUserAction($user);
//var_dump($action);
$result = $action->execute();
var_dump($result);*/
