<?php
include(VIEW_PATH."/front/includes/partials/headerMeta.php");
include(VIEW_PATH."/front/includes/partials/headerOther.php");
include(VIEW_PATH."/front/includes/partials/headerCss.php");
include(VIEW_PATH."/front/includes/partials/headerJs.php");
loader()->get_styles();
loader()->get_header_scripts();
loader()->get_css_stack();
