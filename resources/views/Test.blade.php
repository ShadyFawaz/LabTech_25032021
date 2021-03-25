<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="prism.css" rel="stylesheet" type="text/css" />
    <link href="chosen.css" rel="stylesheet" type="text/css" />
    <script src="jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="chosen.jquery.js" type="text/javascript"></script>
    <script src="prism.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $(".chzn-select").chosen();
        });
</script>
</head>
<body>
    <form id="form1" runat="server">
    <div>

<ion-view view-title="Profile">
<ion-content class="padding">

<div>
    <label class="item item-input">
        <div class="input-label">Enter Your Option</div>
            <select class="chzn-select" multiple="true" name="faculty" style="width:1000px;">
                <option value="Option 2.1">Option 2.1</option>
                <option value="Option 2.2">Option 2.2</option>
                <option value="Option 2.3">Option 2.3</option>
            </select>   
    </label>
</div>
</ion-content>
</ion-view> 
    </div>
    </form>
</body>
</html>