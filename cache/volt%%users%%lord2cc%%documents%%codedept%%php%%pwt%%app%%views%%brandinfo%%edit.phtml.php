<?php echo $this->getContent(); ?>

<?php echo \Phalcon\Tag::form("brandinfo/save") ?>

<table width="100%">
    <tr>
        <td align="left"><?php echo \Phalcon\Tag::linkTo(array("brandinfo", "Back")) ?></td>
        <td align="right"><?php echo \Phalcon\Tag::submitButton(array("Save")) ?></td>
    <tr>
</table>

<div align="center">
    <h1>Edit brandinfo</h1>
</div>

    <table align="center">
        <tr>
            <td align="right">
                <label for="ID">ID</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("ID", "type" => "numeric")) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="NAME">NAME</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("NAME", "size" => 30)) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="IS_VISIBEL">IS Of VISIBEL</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("IS_VISIBEL", "type" => "numeric")) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="CREATE_TIME">CREATE Of TIME</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("CREATE_TIME", "type" => "numeric")) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="UPDATE_TIME">UPDATE Of TIME</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("UPDATE_TIME", "type" => "numeric")) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="ONLINE_IDS">ONLINE Of IDS</label>
            </td>
            <td align="left">
                <?php echo \Phalcon\Tag::textArea(array("ONLINE_IDS", "cols" => "40", "rows" => "5")) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="CITY_ID">CITY Of ID</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("CITY_ID", "type" => "numeric")) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="SORT">SORT</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("SORT", "type" => "numeric")) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="IMAGE">IMAGE</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("IMAGE", "size" => 30)) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="BRANDURL">BRANDURL</label>
            </td>
            <td align="left">
            <?php echo \Phalcon\Tag::textField(array("BRANDURL", "size" => 30)) ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label for="TEMPLET">TEMPLET</label>
            </td>
            <td align="left">
                <?php echo \Phalcon\Tag::textArea(array("TEMPLET", "cols" => "40", "rows" => "5")) ?>
            </td>
        </tr>
    </table>
    <?php echo \Phalcon\Tag::endForm() ?>
