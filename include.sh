
# bgl
#
# -f:   Only list files open in vim
# -a:   Only list arguments
bgl() {
    jobs | php $CLI_UTILS/lib/bgl.php $@
}

# up
# -     A single hexadecimal character
up() {
    jobs | php $CLI_UTILS/lib/bgl.php
    eval "$(php $CLI_UTILS/lib/up.php $@)"
}

# paths
#
# $1:   Strict name or pattern of a path
at() {
    php $CLI_UTILS/lib/paths.php $@ 
}

to() {
    [ -z "$@" ] && at || cd $(at $@)
}

# copy
# -|$1 Copy to clipboard stdin or $1
# 
# echo ':)' | copy
# copy file.txt
copy() {
    [ ! -t 0 ] && (cat | xclip -sel clip) || xclip -sel clip $@
}

# paste
# Output the contents of the clipboard
paste() {
    xclip -o -selection clipboard
}

# pick
# Outputs the first file path in the clipboard.
#
# -e:   
# -a   
# -f   
# -F   
pick() {
    [ ! -t 0 ] && cat || paste | php $CLI_UTILS/lib/pick.php $@ 
}

vi() {
    eval "$(php $CLI_UTILS/lib/vi.php $@)"
}

# serve
#
# $1:   Port
# $2:   Router
serve() {
    [ -z "$1" ] && port='8080' || port="$1"
    php -S 127.0.0.1:$port $@
}
