#!/usr/bin/env bash

set_title () {
    echo -e "\033]0;${1}\007"
}

header () {
    printf "${CYAN}${1}${NC}\n"
}

dark () {
    printf "${DARK}${1}${NC}\n"
}

info () {
    printf "\n${GREEN}${1}${NC}\n\n"
}

green () {
    printf "${GREEN}${1}${NC}\n"
}

light_green () {
    printf "${LIGHT_GREEN}${1}${NC}\n"
}

error () {
    printf "\n${RED}${1}${NC}\n\n"
}

comment () {
    printf "\n${YELLOW}${1}${NC}\n\n"
}

no-exec () {
    comment "No-Exec..."
}

enabled () {
    light_green " enabled."
}
disabled () {
    dark " disabled."
}

help_message () {
if [[ ${HELP} == 1 ]]
then
    echo "Options:"
    echo "  --help          - show this message"
    [[ $OPTION_NO_RESTART ]] && echo "  --no-restart    - do not restart container (may cause 'No coverage driver' and/or 'It seems like *app* is not installed.')"
    [[ $OPTION_PHPUNIT ]] && echo "  --unit          - enable phpunit"
    [[ $OPTION_ANALYZE ]] && echo "  --analyze       - enable analysis(PHPStan, Psalm)"
    [[ $OPTION_METRICS ]] && echo "  --metrics       - enable PHPMetrics"
    [[ $OPTION_MULTI_TEST ]] && echo "  --multi         - enable multi-test"
    [[ $OPTION_COVERAGE ]] && echo "  --coverage      - enable code coverage(PHPUnit)"
    [[ $OPTION_ALL ]] && echo "  --all           - enable analysis, phpunit with code coverage and code_sniffer with beautifier (PHPMetrics and multi-tester disabled)"
    [[ $OPTION_BEAUTY ]] && echo "  --beautify      - enable code beautifier"
    [[ $OPTION_BEAUTY ]] && echo "  --beauty        - same as above"
    [[ $OPTION_PROPAGATE ]] && echo "  --propagate     - propagate unrecognized options to underlying script"
    if [[ ${PROPAGATE} == 0 ]]
    then
        exit 0
    fi
fi
}

options_enabled () {
    printf "Container restart"
    if [[ ${RESTART_CONTAINER} == 1 ]]
    then
        enabled
    else
        disabled
    fi

    printf "Analysis"
    if [[ ${ANALYZE} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "PHPMetrics"
    if [[ ${METRICS} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "Multi-tester"
    if [[ ${MULTI_TEST} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "PHPUnit"
    if [[ ${PHPUNIT} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "Coverage"
    if [[ ${COVERAGE} == 1 ]]
    then
        enabled
    else
        disabled
    fi
    printf "Beautifier"
    if [[ ${BEAUTY} == 1 ]]
    then
        enabled
    else
        disabled
    fi

}

generate_report_file () {
    echo "<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <title>${HEADER}</title>
</head>
<body>

<h1>Report &lt;${HEADER}&gt;</h1>

<p>Some links could be empty</p>
<a href='${TMP_DIR_PARTIAL}/${COVERAGE_DIR}/html/index.html'>Coverage report</a><br>
<a href='${TMP_DIR_PARTIAL}/${PHPMETRICS_DIR}/index.html'>Phpmetrics report</a><br>

</body>
</html>" > ${TEST_REPORT_INDEX}
}
