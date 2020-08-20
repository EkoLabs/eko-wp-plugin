'use strict';

const argv = require('minimist')(process.argv.slice(2));
var fs = require('fs')
const spawn = require('cross-spawn');

const mainFile = './eko-video.php';
const versionPattern = /\* Version:     .*/;
const versionString = '* Version:     ';
const newVersion = argv.version;

function addVersionToPlugin() {
    const data = fs.readFileSync(mainFile, { encoding: 'utf8' });
    const result = data.replace(versionPattern, versionString + newVersion);
    fs.writeFileSync(mainFile, result, { encoding: 'utf8' });
}
function pushNewVersion() {
    spawn.sync('git', ['add', './eko-video.php'], { stdio: 'inherit' });
    spawn.sync('git', ['commit', '-m', `created new plugin version: ${newVersion}`], { stdio: 'inherit' });
    spawn.sync('git', ['push', 'origin'], { stdio: 'inherit' });
}
function createVersionTag() {
    spawn.sync('git', ['tag', newVersion], { stdio: 'inherit' });
    spawn.sync('git', ['push', 'origin', newVersion], { stdio: 'inherit' });
}
function runNewVersionTagProcess() {
    if(!newVersion) {
        throw new Error('must specify a version');
    }
    addVersionToPlugin();
    pushNewVersion();
    createVersionTag();
}

runNewVersionTagProcess() ;