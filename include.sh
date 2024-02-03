
# bgl
#
# -f:   Only list files open in vim TODO $EDITOR instead
# -a:   Only list arguments
bgl() {
    jobs | php $(dirname $0)/lib/bgl.php $@
}

# paths
#
# $1:   Strict name or pattern of a path
paths() {
    php $(dirname $0)/lib/paths.php $@ 
}

# paste
# Output the contents of the clipboard
paste() {
    xclip -o -selection clipboard
}

# Is stdin open?
stdin() {
    test ! -t 0
}

# pick
# Outputs the first file path in the clipboard.
#
# -e:   
# -a   
# -f   
# -F   
pick() {
    stdin && cat || paste | php $(dirname $0)/lib/pick.php $@ 
}

edit() {
    $EDITOR $(pick)
}

