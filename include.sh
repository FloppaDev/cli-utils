
# bgl       List background jobs
# -f:       Only list files open in vim
# -a:       Only list arguments
bgl() {
    jobs | php $CLI_UTILS/lib/bgl.php $@
}

# up        List backgroung jobs and interactively open one
# -         A single hexadecimal character
up() {
    jobs | php $CLI_UTILS/lib/bgl.php
    eval "$(php $CLI_UTILS/lib/up.php $@)"
}

# at        List common paths from ./data/paths.json
# $1:       Strict name or pattern of a path
at() {
    php $CLI_UTILS/lib/paths.php $@ 
}

# to        Go to a path from ./data/paths.json
# $1:       Strict name or pattern of a path
to() {
    [ -z "$@" ] && at || cd $(at $@)
}

# copy
# -|$1      Copy to clipboard stdin or $1
# 
# echo ':)' | copy
# copy file.txt
copy() {
    [ ! -t 0 ] && (cat | xclip -sel clip) || xclip -sel clip $@
}

# paste     Output the contents of the clipboard
paste() {
    xclip -o -selection clipboard
}

# pick      Output paths (1 by default) from the clipboard.
# -e:       Only paths that contains a file extension
# -a        All paths
# -f        Only files
# -d        Only directories
#
# pick -af
pick() {
    [ ! -t 0 ] && cat || paste | php $CLI_UTILS/lib/pick.php $@ 
}

# vi        Wrapper around vim
# $1        Path to open in vim, can include line and column numbers
#
# vi file.txt:10:50
# vi file.txt:10
# vi file.txt
# vi
# echo 'Hey' | vi
vi() {
    if [ ! -t 0 ]; then
        cat | vim -
    elif [ -z "$@" ]; then
        vim 
    else
        eval "$(php $CLI_UTILS/lib/vi.php $@)"
    fi
}

# serve     Start a server in current directory
# $1:   Port
# $2:   Router
serve() {
    [ -z "$1" ] && port='8080' || port="$1"
    php -S 127.0.0.1:$port $@
}

# ps1       Sets the PS1 variable
ps1() {
    export PS1="$(php $CLI_UTILS/lib/ps1.php)"
}

# lf        Simple wrapper to format the output of ugrep nicely
# $1        Search pattern
lf() {
    tput rmam
    ugrep --json --line-number --column-number $@ | php $CLI_UTILS/lib/lf.php
    tput smam
}
