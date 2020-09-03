
function BrowseServer (object, type){
	if(typeof(type) == 'undefined'){
		type = 'Images';
	}
    type = 'Files';
	var finder = new CKFinder();
	finder.resourceType = type;
	 finder.selectActionFunction = function( fileUrl, data ) {
        fileUrl =  fileUrl.replace(BASE_URL, "/");
        object.setAttribute('value', fileUrl);
    }
    finder.popup();
}


const editors = {};
function ckeditor5(elementId){
    return  ClassicEditor
        .create( document.getElementById( elementId ), {
            image: {
                resizeUnit: 'px',
                styles: [
                    'alignLeft', 'alignCenter', 'alignRight'
                ],
                toolbar: [
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                    '|',
                    'imageResize',
                    '|',
                    'imageTextAlternative'
                ]
            },
            toolbar: {
                items: [
                    'heading','|','bold','italic','link','bulletedList','numberedList','|','indent','outdent','|','imageUpload','blockQuote','insertTable','mediaEmbed','undo','redo','fontBackgroundColor','codeBlock','code','fontColor','fontSize','fontFamily','highlight','pageBreak','todoList','underline','alignment','horizontalLine'
                ]
            },
        } )
        .then( editor => {
            editors[ elementId ] = editor;
        })
        .catch( error => {
            console.error( 'Oops, something went wrong!' );
            console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
            console.warn( 'Build id: wxciefr33ukx-y6mvs3tvmy81' );
            console.error( error );
        });
}
