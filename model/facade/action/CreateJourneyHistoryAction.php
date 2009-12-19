<?php

/** File for CreateJourneyHistoryAction
 *
 *  This file just contains {@link CreateJourneyHistoryAction}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

include_once('phpreport/model/facade/action/Action.php');
include_once('phpreport/model/dao/DAOFactory.php');
include_once('phpreport/model/vo/JourneyHistoryVO.php');

/** Create Journey History entry Action
 *
 *  This action is used for creating a new entry on Journey History.
 *
 * @package PhpReport
 * @subpackage facade
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */
class CreateJourneyHistoryAction extends Action{

    /** The Journey History
     *
     * This variable contains the Journey History entry we want to create.
     *
     * @var JourneyHistoryVO
     */
    private $journeyHistory;

    /** CreateJourneyHistoryAction constructor.
     *
     * This is just the constructor of this action.
     *
     * @param JourneyHistoryVO $journeyHistory the Journey History value object we want to create.
     */
    public function __construct(JourneyHistoryVO $journeyHistory) {
        $this->journeyHistory=$journeyHistory;
        $this->preActionParameter="CREATE_JOURNEY_HISTORY_PREACTION";
        $this->postActionParameter="CREATE_JOURNEY_HISTORY_POSTACTION";

    }

    /** Specific code execute.
     *
     * This is the function that contains the code that creates the new Journey History entry, storing it persistently.
     *
     * @return int it just indicates if there was any error (<i>-1</i>) or not (<i>0</i>).
     * @throws {@link SQLQueryErrorException}, {@link SQLUniqueViolationException}
     */
    protected function doExecute() {

    $dao = DAOFactory::getJourneyHistoryDAO();
        if ($dao->create($this->journeyHistory)!=1) {
            return -1;
        }

        return 0;
    }

}


/*//Test code

$journeyhistoryvo= new JourneyHistoryVO();
$journeyhistoryvo->setJourney(5);
$journeyhistoryvo->setUserId(1);
$journeyhistoryvo->setInitDate(date_create("2009-01-01"));
$journeyhistoryvo->setEndDate(date_create("2009-06-01"));
$action= new CreateJourneyHistoryAction($journeyhistoryvo);
var_dump($action);
$action->execute();
var_dump($journeyhistoryvo);
*/
