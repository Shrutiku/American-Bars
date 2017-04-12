<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function form_ckeditor($data)
{
    $data['language'] = isset($data['language']) ? $data['language'] : 'es';
    
    $size    = isset($data['width']) ? 'width: "'.$data['width'].'", ' : '';
    $size  .= isset($data['height']) ? 'height: "'.$data['height'].'", ' : '';
    
    $options = '{'.
            $size.
            'language: "'.$data['language'].'", 
            
            stylesCombo_stylesSet: "my_styles",
            
            startupOutlineBlocks: true,
            entities: false,
            entities_latin: false,
            entities_greek: false,
            forcePasteAsPlainText: false,
            
            filebrowserImageUploadUrl : "filexplorers/fckeditor_upload/image",
            filebrowserImageBrowseUrl : "filexplorers/inlinebrowse/image", 
            filebrowserImageWindowWidth : "80%",
            filebrowserImageWindowHeight : "80%",   

            
            toolbar :[
                ["Source","-","FitWindow","ShowBlocks","-","Preview"],
                ["Undo","Redo","-","Find","Replace","-","SelectAll","RemoveFormat"],
                ["Cut","Copy","Paste","PasteText","PasteWord","-","Print","SpellCheck"],
                ["Form","Checkbox","Radio","TextField","Textarea","Select","Button","ImageButton","HiddenField"],
                ["About"],
                    
                "/",
                
                ["Bold","Italic","Underline"],
                ["OrderedList","UnorderedList","-","Blockquote","CreateDiv"],
                
                ["Image","Flash","Table"],
                
                ["Link","Unlink","Anchor"],
                ["Rule","SpecialChar"],
                ["Styles"]
            ]
        }';
    
    
    $my_styles = 'CKEDITOR.addStylesSet("my_styles",
        [
         
            { name : "H3", element : "h3"},
            { name : "Heading 4", element : "h4"},
            { name : "Heading 5", element : "h5"},
            { name : "Heading 6", element : "h6"},
            { name : "Document Block", element : "div"},
            { name : "Preformatted Text", element : "pre"},
            { name : "Address", element : "address"},
        
           
            { name: "Centered paragraph", element: "p", attributes: { "class": "center" } },
            
            { name: "IMG bordered", element: "img", attributes: { "class": "bordered" } },
            
            { name: "IMG left", element: "img", attributes: { "class": "left" } },
            { name: "IMG right", element: "img", attributes: { "class": "right" } },
            
            { name: "IMG left bordered", element: "img", attributes: { "class": "left bordered" } },
            { name: "IMGright bordered", element: "img", attributes: { "class": "right bordered" } },
        ]);';
    
    return 
    // fix: move to <HEAD...
   

    // put the CKEditor
     '< script type="text/javascript">' .
            $my_styles .
            'CKEDITOR.replace("'.$data['id'].'", ' . $options . ');'.'<\/script>';
}

function form_ckeditor1($data)
{
    return '< script type="text/javascript" src="'.base_url().'ckeditor/ckeditor.js"></ script>' .
     '< script type="text/javascript">CKEDITOR.replace("'.$data['id'].'");</ script>';
} 

// To use:
// echo form_ckeditor(array(
            // 'id'              =&gt; 'textarea_id',
            // 'width'           => '500',
            // 'height'          => '300',
            // 'value'         => htmlentities($textarea_value)
        // ));