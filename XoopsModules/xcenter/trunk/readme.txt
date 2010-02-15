I tried for days to track down the author of XT Conteudo but had no luck.  So unfortunately I've had to release this as a new module.  It is heavily base on XT Conteudo which is based on Tiny Content.  I've made several additions, and I'll try to keep them listed here.

New Features

FCKEditor - I replaced SPAW with the cross browser FCKEditor.  If you have ASPELL installed on the server, FCKeditor will allow you to spell check your content areas.  You'll need to edit \content\admin\fckeditor\editor\dialog\fck_spellerpages\spellerpages\server-scripts\spellchecker.php and change $aspell_prog to point to your aspell executable.

Priority - I've changed the way the priority works so that you can put submenu items into a specific order under the main level items.

External Links - I added the ability to set an external link instead of HTML content

Content Menu Block - I've edited the menu block so it would display submenu items based on where you are in the module.  This gives you the appearance of sections and navigation that adapts based on your current position.

Site Menu Block - This menu block incorporates both the module main menu, and the Content Menu into one site level Menu. There is an admin menu to order the modules and content.

DHTML(CSS) Site Menu Block - This block is the same as the standard Site Menu block but adds dhtml submenus where applicable.

Spring Cleaning - I’ve pulled out the extra menu blocks and have only the ones described above.  I’ve also tried to remove any unnecessary files.

