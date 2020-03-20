<?php
# This function is heliping to Remove duplicate form multidimentional
# array using below php build in functions
# array_map, array_unique, serialize, unserialize
# It return the unique multidimensioanl array

function remove_duplicate_from_multi_dim_arr(array $multi_dimn_arr){

    return array_map("unserialize", array_unique(array_map("serialize", $multi_dimn_arr)));
}