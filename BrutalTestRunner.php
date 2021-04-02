<?php
/**
 * Copyright (C) 2021  PetitCitron osd.ovh - https://github.com/PetitCitron
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * This PHP lib provide a brutal and minimalist way to test lib for minimalist projet
 *
 * Contact:         https://github.com/PetitCitron  @PetitCitron
 * Contrib Src:     https://github.com/PetitCitron/BrutalTestRunner
 * WWW:             https://osd.ovh
 */

# Configure
$GLOBALS['debug'] = false; // if you want more FAILED test info

# Internals
$GLOBALS['tests_count'] = 0;
$GLOBALS['tests_failed_count'] = 0;
$GLOBALS['tests_success_count'] = 0;

/**
 * AssertEqual - Only 1 and unique Assertion test system.
 *
 * @param mixed  $expect value you may have
 * @param mixed  $found  var you test
 * @param string $msg    general msg which explain what test is
 * @param bool   $strict if you want a strict test equality
 *
 * @return bool
 */
function btrAssertEq($expect, $found, string $msg, bool $strict = false): bool
{
    $GLOBALS['tests_count']++;
    if ($strict && $expect === $found) {
        $GLOBALS['tests_success_count']++;
        print "test {$GLOBALS['tests_count']} ::s OK ✔ :: $msg\n";
        return true;
    }
    if (!$strict && $expect == $found) {
        $GLOBALS['tests_success_count']++;
        print "test {$GLOBALS['tests_count']} :: OK ✔ :: $msg\n";
        return true;
    }
    $GLOBALS['tests_failed_count']++;
    print "test {$GLOBALS['tests_count']} :: FAIL ✖ :: $msg\n";
    if ($GLOBALS['debug']) {
        print "    $expect != $found \n";
        print "---------------\nEXPECT :\n";
        var_export($expect);
        print "\nFOUND :\n";
        var_export($found);
        print "\n---------------\n";
        die('Tests FAILED');
    }
    return false;
}

/**
 * Only print a script Header tout output
 *
 * @param string $file
 */
function btrHeader(string $file): void
{
    print "\n-----------\n";
    $fname = basename($file);
    print  "Brutal test Runner for [$fname]\n";
}

/**
 * Out script with summary and good exit code
 */
function btrFooter(): void
{
    print "\n-----------\n";
    if ($GLOBALS['tests_failed_count']) {
        print '✖ [FAILED] ';
        print "{$GLOBALS['tests_failed_count']} fails, {$GLOBALS['tests_success_count']} success, {$GLOBALS['tests_count']} total ";
        exit(1);
    }
    else {
        print '✔ [SUCCESS] ';
        print "{$GLOBALS['tests_failed_count']} fails, {$GLOBALS['tests_success_count']} success, {$GLOBALS['tests_count']} total ";
        exit(0);
    }
}