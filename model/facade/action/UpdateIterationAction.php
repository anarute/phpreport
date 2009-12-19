<?php

/** File for UpdateIterationAction
 *
 *  This file just contains {@link UpdateIterationAction}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

include_once('phpreport/model/facade/action/Action.php');
include_once('phpreport/model/dao/DAOFactory.php');
include_once('phpreport/model/vo/UserVO.php');

/** Update Iteration Action
 *
 *  This action is used for updating an Iteration.
 *
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */
class UpdateIterationAction extends Action{

    /** The Iteration
     *
     * This variable contains the Iteration we want to update.
     *
     * @var IterationVO
     */
    private $iteration;

    /** UpdateIterationAction constructor.
     *
     * This is just the constructor of this action.
     *
     * @param IterationVO $iteration the Iteration value object we want to update.
     */
    public function __construct(IterationVO $iteration) {
        $this->iteration=$iteration;
        $this->preActionParameter="UPDATE_ITERATION_PREACTION";
        $this->postActionParameter="UPDATE_ITERATION_POSTACTION";

    }

    /** Specific code execute.
     *
     * This is the function that contains the code that updates the Iteration on persistent storing.
     *
     * @return int it just indicates if there was any error (<i>-1</i>) or not (<i>0</i>).
     * @throws {@link SQLQueryErrorException}, {@link SQLUniqueViolationException}
     */
    protected function doExecute() {

    $dao = DAOFactory::getIterationDAO();
        if ($dao->update($this->iteration)!=1) {
            return -1;
        }

        return 0;
    }

}

/*
//Test code

$iterationvo= new IterationVO();
$iterationvo->setId(1);
$iterationvo->setName('Pizza Deliverers');
$action= new UpdateIterationAction($iterationvo);
var_dump($action);
$action->execute();
var_dump($iterationvo);
*/
