<?php

/** File for UserGroupVO
 *
 *  This file just contains {@link UserGroupVO}.
 *
 * @filesource
 * @package PhpReport
 * @subpackage VO
 * @author Jorge L�pez Fern�ndez <jlopez@igalia.com>
 */

/** VO for User Groups
 *
 *  This class just stores User Group data.
 *
 *  @property int $id database internal identifier.
 *  @property string $name name of the User Group.
 */
class UserGroupVO {

    /**#@+
     *  @ignore
     */
    protected $id = NULL;
    protected $name = NULL;

    public function setId($id) {
        if (is_null($id))
        $this->id = $id;
    else
            $this->id = (int) $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = (string) $name;
    }

    public function getName() {
        return $this->name;
    }

    /**#@-*/

}
