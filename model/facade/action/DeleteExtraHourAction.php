<?php

/** File for DeleteExtraHourAction
 *
 *  This file just contains {@link DeleteExtraHourAction}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

include_once('phpreport/model/facade/action/Action.php');
include_once('phpreport/model/dao/DAOFactory.php');
include_once('phpreport/model/vo/ExtraHourVO.php');

/** Delete Extra Hour Action
 *
 *  This action is used for deleting a Extra Hour.
 *
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */
class DeleteExtraHourAction extends Action{

    /** The Extra Hour
     *
     * This variable contains the Extra Hour we want to delete.
     *
     * @var ExtraHourVO
     */
    private $extraHour;

    /** DeleteExtraHourAction constructor.
     *
     * This is just the constructor of this action.
     *
     * @param ExtraHourVO $extraHour the Extra Hour value object we want to delete.
     */
    public function __construct(ExtraHourVO $extraHour) {
        $this->extraHour=$extraHour;
        $this->preActionParameter="DELETE_EXTRA_HOUR_PREACTION";
        $this->postActionParameter="DELETE_EXTRA_HOUR_POSTACTION";

    }

    /** Specific code execute.
     *
     * This is the function that contains the code that deletes the Extra Hour from persistent storing.
     *
     * @return int it just indicates if there was any error (<i>-1</i>) or not (<i>0</i>).
     */
    protected function doExecute() {

    $dao = DAOFactory::getExtraHourDAO();
        if ($dao->delete($this->extraHour)!=1) {
            return -1;
        }

        return 0;
    }

}


/*//Test code

$uservo= new UserVO();
$uservo->setLogin('jjsantos');
$uservo->setPassword('jaragunde');
$action= new CreateUserAction($uservo);
var_dump($action);
$action->execute();
var_dump($uservo);
*/
