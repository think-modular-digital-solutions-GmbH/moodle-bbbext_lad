<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Contains the mod instance helper class for the LAD extension
 *
 * @package    bbbext_lad
 * @copyright  2026, think modular
 * @author     think modular (stefan.weber@think-modular.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace bbbext_lad\bigbluebuttonbn;

use stdClass;

/**
 * Class defining a way to deal with instance save/update/delete in extension
 *
 * @package   mod_bigbluebuttonbn
 * @copyright 2023 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Laurent David (laurent@call-learning.fr)
 */
class mod_instance_helper extends \mod_bigbluebuttonbn\local\extension\mod_instance_helper {
    /**
     * Runs any processes that must run before a bigbluebuttonbn insert/update.
     *
     * @param stdClass $bigbluebuttonbn BigBlueButtonBN form data
     **/
    public function add_instance(stdClass $bigbluebuttonbn) {
        global $DB;
        $DB->insert_record('bbbext_lad', (object) [
            'bigbluebuttonbnid' => $bigbluebuttonbn->id,
            'enabled' => $bigbluebuttonbn->lad_enable ?? 0,
        ]);
    }

    /**
     * Runs any processes that must be run after a bigbluebuttonbn insert/update.
     *
     * @param stdClass $bigbluebuttonbn BigBlueButtonBN form data
     **/
    public function update_instance(stdClass $bigbluebuttonbn): void {
        global $DB, $PAGE;
        $enabled = $bigbluebuttonbn->lad_enable ?? 0;
        $instanceid = $PAGE->cm->instance;
        $secret = uniqid();

        // Get existing config.
        if ($record = $DB->get_record('bbbext_lad', ['bigbluebuttonbnid' => $instanceid])) {
            $record->enabled = $enabled;
            $record->secret = $secret;
            $DB->update_record('bbbext_lad', $record);
        } else {
            // Create new config.
            $record = new stdClass();
            $record->bigbluebuttonbnid = $instanceid;
            $record->enabled = $enabled;
            $record->secret = $secret;
            $DB->insert_record('bbbext_lad', $record);
        }
    }

    /**
     * Runs any processes that must be run after a bigbluebuttonbn delete.
     *
     * @param int $id
     */
    public function delete_instance(int $id): void {
        global $DB;
        $DB->delete_records('bbbext_lad', [
            'bigbluebuttonbnid' => $id,
        ]);
    }

    /**
     * Get any join table name that is used to store additional data for the instance.
     * @return string[]
     */
    public function get_join_tables(): array {
        return ['bbbext_lad'];
    }
}
