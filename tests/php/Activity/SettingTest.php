<?php
/**
 * @copyright Copyright (c) 2017 Joas Schilling <coding@schilljs.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Talk\Tests\php\Activity;

use OCA\Talk\Activity\Setting;
use OCP\Activity\ISetting;
use Test\TestCase;

class SettingTest extends TestCase {

	public function dataSettings() {
		return [
			[Setting::class],
		];
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testImplementsInterface($settingClass) {
		$setting = \OC::$server->query($settingClass);
		$this->assertInstanceOf(ISetting::class, $setting);
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testGetIdentifier($settingClass) {
		/** @var ISetting $setting */
		$setting = \OC::$server->query($settingClass);
		$this->assertInternalType('string', $setting->getIdentifier());
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testGetName($settingClass) {
		/** @var ISetting $setting */
		$setting = \OC::$server->query($settingClass);
		$this->assertInternalType('string', $setting->getName());
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testGetPriority($settingClass) {
		/** @var ISetting $setting */
		$setting = \OC::$server->query($settingClass);
		$priority = $setting->getPriority();
		$this->assertInternalType('int', $setting->getPriority());
		$this->assertGreaterThanOrEqual(0, $priority);
		$this->assertLessThanOrEqual(100, $priority);
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testCanChangeStream($settingClass) {
		/** @var ISetting $setting */
		$setting = \OC::$server->query($settingClass);
		$this->assertInternalType('bool', $setting->canChangeStream());
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testIsDefaultEnabledStream($settingClass) {
		/** @var ISetting $setting */
		$setting = \OC::$server->query($settingClass);
		$this->assertInternalType('bool', $setting->isDefaultEnabledStream());
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testCanChangeMail($settingClass) {
		/** @var ISetting $setting */
		$setting = \OC::$server->query($settingClass);
		$this->assertInternalType('bool', $setting->canChangeMail());
	}

	/**
	 * @dataProvider dataSettings
	 * @param string $settingClass
	 */
	public function testIsDefaultEnabledMail($settingClass) {
		/** @var ISetting $setting */
		$setting = \OC::$server->query($settingClass);
		$this->assertInternalType('bool', $setting->isDefaultEnabledMail());
	}
}
