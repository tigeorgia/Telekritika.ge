/* Showcase
-------------*/

#awOnePageButton .view-slide
{
    display: none;
}

/* This class is removed after the showcase is loaded */
/* Assign the correct showcase height to prevent loading jumps in IE */

#mainslider .showcase-load
{
    height: 470px; /* Same as showcase javascript option */
    overflow: hidden;
}

/* Container when content is shown as one page */
.showcase-onepage
{
    /**/
}

/* Container when content is shown in slider */
.showcase
{
    position: relative;
    margin: auto;
}

    .showcase-content-container
    {
        background-color: #000;
    }
    
    /* Navigation arrows */
    .showcase-arrow-previous, .showcase-arrow-next
    {
        position: absolute;
        background: url('../images/arrows.png');
        width: 33px;
        height: 33px;
        top: 220px;
        cursor: pointer;
    }
    
    .showcase-arrow-previous
    {
        left: -60px;
    }
    
    .showcase-arrow-previous:hover
    {
        background-position: 0px -34px;
    }
    
    .showcase-arrow-next
    {
        right: -56px;
        background-position: -34px 0;
    }
    
    .showcase-arrow-next:hover
    {
        background-position: -34px -34px;
    }
    
    /* Content */
    .showcase-content
    {
        background-color: #000;
        text-align: center;
    }
        
        .showcase-content-wrapper
        {
            text-align: center;
            height: 470px;
            width: 700px;
            display: table-cell;
            vertical-align: middle;
        }
        
        /* Styling the tooltips */
        .showcase-plus-anchor
        {
            background-image: url('../images/plus.png');
            background-repeat: no-repeat;
        }
        
        .showcase-plus-anchor:hover
        {
            background-position: -32px 0;
        }
        
        div.showcase-tooltip
        {
            background-color: #fff;
            color: #000;
            text-align: left;
            padding: 5px 8px;
            background-image: url(../images/white-opacity-80.png);
        }
        
        /* Styling the caption */
        .showcase-caption
        {
            color: #000;
            padding: 8px 15px;
            text-align: left;
            position: absolute;
            bottom: 10px; left: 10px; right: 10px;
            display: none;
            background-image: url(../images/white-opacity-80.png);
        }
        
    .showcase-onepage .showcase-content
    {
        margin-bottom: 10px;
    }
    
    /* Button Wrapper */
    .showcase-button-wrapper
    {
        clear: both;
        margin-top: 10px;
        text-align: center;
    }
    
        .showcase-button-wrapper span
        {
            margin-right: 3px;
            padding: 2px 5px 0px 5px;
            cursor: pointer;
            font-size: 12px;
            color: #444444;
        }
    
        .showcase-button-wrapper span.active
        {
            color: #fff;
        }
    
    /* Thumbnails */
    .showcase-thumbnail-container /* Used for backgrounds, no other styling!!! */
    {
        background-color: #000;
    }
    
    .showcase-thumbnail-wrapper
    {
        overflow: hidden;
    }
        
        .showcase-thumbnail
        {
            width: 120px;
            height: 90px;
            cursor: pointer;
            border: solid 1px #333;
            position: relative;
        }
        
            .showcase-thumbnail-caption
            {
                position: absolute;
                bottom: 2px;
                padding-left: 10px;
                padding-bottom: 5px;
            }
            
            .showcase-thumbnail-content
            {
                padding: 10px;
                text-align: center;
                padding-top: 25px;
            }
            
            .showcase-thumbnail-cover
            {
                background-image: url(../images/black-opacity-40.png);
                position: absolute;
                top: 0; bottom: 0; left: 0; right: 0;
            }
        
        .showcase-thumbnail:hover
        {
            border: solid 1px #999;
        }
        
            .showcase-thumbnail:hover .showcase-thumbnail-cover
            {
                display: none;
            }
        
        .showcase-thumbnail.active
        {
            border: solid 1px #999;
        }
        
            .showcase-thumbnail.active .showcase-thumbnail-cover
            {
                display: none;
            }
    
    .showcase-thumbnail-wrapper-horizontal
    {
        padding: 10px;
    }
    
        .showcase-thumbnail-wrapper-horizontal .showcase-thumbnail
        {
            margin-right: 10px;
            width: 116px;
        }
    
    .showcase-thumbnail-wrapper-vertical
    {
        padding: 10px;
    }
    
        .showcase-thumbnail-wrapper-vertical .showcase-thumbnail
        {
            margin-bottom: 10px;
        }
        
    .showcase-thumbnail-button-backward,
    .showcase-thumbnail-button-forward
    {
        padding: 7px;
        cursor: pointer;
    }
    
    .showcase-thumbnail-button-backward
    {
        padding-bottom: 0px;
        padding-right: 0px;
    }
    
        .showcase-thumbnail-button-backward .showcase-thumbnail-vertical,
        .showcase-thumbnail-button-forward .showcase-thumbnail-vertical,
        .showcase-thumbnail-button-forward .showcase-thumbnail-horizontal,
        .showcase-thumbnail-button-backward .showcase-thumbnail-horizontal
        {
            background-image: url(../images/arrows-small.png);
            background-repeat: no-repeat;
            display: block;
            width: 17px;
            height: 17px;
        }
        
        .showcase-thumbnail-button-backward .showcase-thumbnail-vertical
        {
            background-position: 0 -51px;
            margin-left: 55px;
        }
        .showcase-thumbnail-button-backward:hover .showcase-thumbnail-vertical
        {
            background-position: -17px -51px;
        }
        
        .showcase-thumbnail-button-forward .showcase-thumbnail-vertical
        {
            background-position: 0 -34px;
            margin-left: 55px;
        }
        .showcase-thumbnail-button-forward:hover .showcase-thumbnail-vertical
        {
            background-position: -17px -34px;
        }
        
        .showcase-thumbnail-button-backward .showcase-thumbnail-horizontal
        {
            background-position: 0 -17px;
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .showcase-thumbnail-button-backward:hover .showcase-thumbnail-horizontal
        {
            background-position: -17px -17px;
        }
        
        .showcase-thumbnail-button-forward .showcase-thumbnail-horizontal
        {
            background-position: 0 0;
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .showcase-thumbnail-button-forward:hover .showcase-thumbnail-horizontal
        {
            background-position: -17px 0;
        }
        
        /* Hide button text */
        .showcase-thumbnail-button-forward span span,
        .showcase-thumbnail-button-backward span span
        {
            display: none;
        }
    


/* Clear (used for horizontal thumbnails)
-------------------------------------------*/

.clear
{
    clear: both;
    display: block;
    overflow: hidden;
    visibility: hidden;
    width: 0;
    height: 0;
    float: none;
}