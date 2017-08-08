<?php
/**
 * Created by PhpStorm.
 * User: niran
 * Date: 5/29/2017
 * Time: 5:36 PM
 */
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<style>

    body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
    }

    .bs-example {
        position: relative;
        padding: 45px 15px 15px;
        margin: 0 -15px 15px;
        border-color: #e5e5e5 #eee #eee;
        border-style: solid;
        border-width: 1px 0;
        -webkit-box-shadow: inset 0 3px 6px rgba(0,0,0,.05);
        box-shadow: inset 0 3px 6px rgba(0,0,0,.05);
    }

    .bs-example:after {
        position: absolute;
        top: 15px;
        left: 15px;
        font-size: 12px;
        font-weight: 700;
        color: #959595;
        text-transform: uppercase;
        letter-spacing: 1px;
        content: "Add New Fired Event";
    }

    .form-outer-container {
        text-align: center;
        padding: 40px;
    }

    .form-container {
        display: inline-block;
    }

    @media (min-width: 768px) {
        .bs-example {
            margin-right: 0;
            margin-left: 0;
            background-color: #fff;
            border-color: #ddd;
            border-width: 1px;
            border-radius: 4px 4px 0 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    }

</style>


<div class="container">

    <div class="row">

        <div class="col-sm-offset-2 col-md-8">

            <div class="form-outer-container">

                <div class="bs-example">

                    <div class="form-container">

                        <form method="<?= $method ?>" class="form-horizontal" action="<?= $action ?>">
                            <? foreach( $fields as $field ) : ?>
                                <div class="form-group">
                                    <? if( $field["type"] != "hidden" ) : ?>
                                    <label for="<?= $field["name"] ?>"><?= $field["name"] ?>:&nbsp;</label>
                                    <? endif; ?>
                                    <input type="<?= $field["type"] ?>" name="<?= $field["name"] ?>" id="<?= $field["name"] ?>" value="<?= $field["value"] ?>" />
                                </div>
                            <? endforeach; ?>
                            <button type="submit" class="btn btn-default">Add Event</button>
                        </form>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>