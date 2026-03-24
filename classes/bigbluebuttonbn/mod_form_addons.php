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
 * Contains the mod form extension class for the LAD extension
 *
 * @package    bbbext_lad
 * @copyright  2026, think modular
 * @author     think modular (stefan.weber@think-modular.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace bbbext_lad\bigbluebuttonbn;

use stdClass;
use moodle_url;

/**
 * Allows modules to modify the data returned by form get_data().
 * This method is also called in the bulk activity completion form.
 *
 * Only available on moodleform_mod.
 *
 * @package    bbbext_lad
 * @copyright  2026, think modular
 * @author     think modular (stefan.weber@think-modular.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_form_addons extends \mod_bigbluebuttonbn\local\extension\mod_form_addons {
    /**
     * Add new form field definition
     */
    public function add_fields(): void {

        global $CFG, $PAGE;

        $this->mform->addElement('header', 'lad', get_string('pluginname', 'bbbext_lad'));

        // Enable.
        $this->mform->addElement('checkbox', 'lad_enable', get_string('enable'));
        $this->mform->setType('lad_enable', PARAM_INT);
        $this->mform->addHelpButton('lad_enable', 'enable', 'bbbext_lad');
    }

    /**
     * Preprocess form data.
     *
     * @param array|null $defaultvalues
     * @return void
     */
    public function data_preprocessing(?array &$defaultvalues): void {
        $default = get_config('bbbext_lad', 'enabled');
        if (!empty($defaultvalues['id'])) {
            $instanceid = $defaultvalues['id'];

            global $DB;

            if ($record = $DB->get_record('bbbext_lad', ['bigbluebuttonbnid' => $instanceid])) {
                $default = $record->enabled;
            }
        }

        $defaultvalues['lad_enable'] = $default;
    }

    /**
     * Validate form and returns an array of errors indexed by field name
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation(array $data, array $files): array {
        return [];
    }

    /**
     * We have no custom completion rules.
     *
     * @return array Array of string IDs of added items, empty array if none
     */
    public function add_completion_rules(): array {
        return [];
    }

    /**
     * Save our setting in post processing.
     *
     * @param \stdClass $data The data from the form
     * @return void
     */
    public function data_postprocessing(\stdClass &$data): void {
    }
}
