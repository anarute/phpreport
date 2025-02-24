<?php
/*
 * Copyright (C) 2013 Igalia, S.L. <info@igalia.com>
 *
 * This file is part of PhpReport.
 *
 * PhpReport is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PhpReport is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PhpReport.  If not, see <http://www.gnu.org/licenses/>.
 */


/** File for PartialUpdateTasksAction
 *
 *  This file just contains {@link PartialUpdateTasksAction}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage facade
 * @author Jacobo Aragunde Pérez <jaragunde@igalia.com>
 */

include_once(PHPREPORT_ROOT . '/model/facade/action/Action.php');
include_once(PHPREPORT_ROOT . '/model/dao/DAOFactory.php');
include_once(PHPREPORT_ROOT . '/model/vo/TaskVO.php');

/** Partial Update Tasks Action
 *
 *  This action is used for updating only some fields of a set of Task objects.
 *
 * @package PhpReport
 * @subpackage facade
 * @author Jacobo Aragunde Pérez <jaragunde@igalia.com>
 */
class PartialUpdateTasksAction extends Action{

    /** The Task
     *
     * This variable contains an array with the Task objects we want to update.
     * The elements of the array must be DirtyTaskVO objects to contain the
     * information about which fields must be updated.
     *
     * @var array<DirtyTaskVO>
     */
    private $tasks;

    /** PartialUpdateTasksAction constructor.
     *
     * This is just the constructor of this action.
     *
     * @param array $tasks an array with the Task objects we want to update.
     * The elements of the array must be DirtyTaskVO objects to contain the
     * information about which fields must be updated.
     */
    public function __construct($tasks) {
        $this->tasks=$tasks;
        $this->preActionParameter="PARTIAL_UPDATE_TASKS_PREACTION";
        $this->postActionParameter="PARTIAL_UPDATE_TASKS_POSTACTION";

    }

    /** Specific code execute.
     *
     * Runs the action itself.
     *
     * @return int it just indicates if there was any error (<i>-1</i>)
     *         or not (<i>0</i>).
     */
    protected function doExecute() {
        $configDao = DAOFactory::getConfigDAO();
        $taskDao = DAOFactory::getTaskDAO();
        $projectDAO = DAOFactory::getProjectDAO();
        $discardedTasks = array();

        //first check permission on task write
        foreach ($this->tasks as $i => $task) {
            // Do not allow assigning a task to a locked date
            if ($task->isDateDirty()) {
                if(!$configDao->isWriteAllowedForDate($task->getDate())) {
                    $discardedTasks[] = $task;
                    unset($this->tasks[$i]);
                    continue;
                }
            }

            // Do not allow updating tasks saved in locked dates or belonging
            // to a different user
            $oldTask = $taskDao->getById($task->getId());
            if(!$configDao->isWriteAllowedForDate($oldTask->getDate()) ||
                    (!$taskDao->checkTaskUserId(
                        $task->getId(), $task->getUserId()))) {
                $discardedTasks[] = $task;
                unset($this->tasks[$i]);
                continue;
            }

            // Do not allow assigning a task to an inactive project
            if ($task->isProjectIdDirty()) {
                $projectId = $task->getProjectId();
                $projectVO = $projectDAO->getById($projectId);
                if (!$projectVO || !$projectVO->getActivation()) {
                    $discardedTasks[] = $task;
                    unset($this->tasks[$i]);
                    continue;
                }
            }

            // Do not allow updating tasks which belong to inactive projects
            $projectId = $oldTask->getProjectId();
            $projectVO = $projectDAO->getById($projectId);
            if (!$projectVO || !$projectVO->getActivation()) {
                $discardedTasks[] = $task;
                unset($this->tasks[$i]);
            }
        }

        if ($taskDao->batchPartialUpdate($this->tasks) < count($this->tasks)) {
            return -1;
        }

        //TODO: do something meaningful with the list of discarded tasks
        if (empty($discardedTasks)) {
            return 0;
        }
        else {
            return -1;
        }
    }

}
