<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function productList(Request $request)
    {
        /*Here is the product list for testing */
        $productsArr = [
            ['name' => 'PHP/Laravel Basic To advance', 'price' => 20.99, 'category' => 'Backend Development'],
            ['name' => 'Laravel with Vue Js Full course', 'price' => 30.99, 'category' => 'Full Stack Development'],
            ['name' => 'Learn Javascript with React,Redux', 'price' => 40.99, 'category' => 'Frontend Development'],
            ['name' => 'Linux adminstrator with Docker,Jenkins,AWS', 'price' => 50.99, 'category' => 'Devops'],
        ];

        /*I called filterProducts function with arguments
        (1) 1st one is $productsArr
        (2) 2nd one is our filtered keyword
        */
        $filteredProductList = $this->filterProducts($productsArr, 'Development');

        /*If result found then print this value*/
        echo '<table>';
        echo '<tr><th>Name</th><th>Price</th><th>Category</th></tr>';
        if (count($filteredProductList) > 0) {
            foreach ($filteredProductList as $product) {
                echo '<tr>';
                echo '<td>' . $product['name'] . '</td>';
                echo '<td>' . $product['price'] . '</td>';
                echo '<td>' . $product['category'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr>';
            echo '<td>' . 'No Product Fount' . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }




    public function filterProducts($products, $categoryName)
    {
        /*
        (1) 1st of all I called array_filter() function. array_filter() function takes 2 parameter. 1st one is array and
        2nd one is callback function. our main logic written here.
        If out conition fullfilled then it will return a new filtered array.
        */
        $filteredProducts = array_filter($products, function ($product) use ($categoryName) {
            return $this->filterByCategory($product, $categoryName);
        });

        return $filteredProducts;
    }


    public function filterByCategory($product, $categoryName)
    {
        /*
        (1) Here I get 2 parameter $product, $categoryName.
        (2)then I call strpos() funcation & passed argument. strpos() function finds the position of the
        first occurrence of a string inside another string. & its a case-sensitive.

        (3) So we call strtolower() function that our both parameter are same cases.
        (4) If matches then strpos() function return true. We just return matches value.
        */
        return strpos(strtolower($product['category']), strtolower($categoryName)) == true;
    }

}
