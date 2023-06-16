function initMigrationView(){
    document.querySelectorAll('#login-bar .col-sm-12.col-md-3.text-right').forEach((loginBarLink)=>{loginBarLink.remove()});
    if (countSelectedElement()>=2){
        displayMultiSelector();
    }
    if (window.location.href.includes('?')){
    window.history.replaceState(null,null,window.location.href.split('?')[0]);
    }

    document.querySelectorAll('.migrationTable:not(.migrationHistoryTable) tbody tr').forEach((tableMigrationRow)=>{
        tableMigrationRow.addEventListener('click',(event)=>{
            if (event.target.tagName!=='INPUT')
                tableMigrationRow.querySelector('input').checked=!tableMigrationRow.querySelector('input').checked;
            if ((event.target.classList.contains('migrationModuleIndex'))||event.target.parentElement.parentElement.classList.contains('migrationModuleIndex')){
                const moduleName=event.target.innerText===''?event.target.parentElement.parentElement.innerText:event.target.innerText;
                const indexChecked=event.target.querySelector('input')!==null?event.target.querySelector('input').checked:event.target.parentElement.querySelector('input').checked;
                document.querySelectorAll('.migrationTable:not(.migrationHistoryTable) tr:not(.migrationModuleIndex) td:nth-of-type(2)').forEach((moduleRowElementText)=>{
                    if (moduleRowElementText.innerText===moduleName){
                        moduleRowElementText.parentElement.querySelector('input').checked=indexChecked;
                    }
                })
            }
        });

    });
    document.querySelector('.migrationTable:not(.migrationHistoryTable)').addEventListener('click',(event)=>{

        if (countSelectedElement()>=2){
            displayMultiSelector();
        }
        else{
            hideMultiSelector();
        }
    });
    const cookies=document.cookie.split(';');
    cookies.forEach((cookie)=>{
        if (cookie.includes('selected')){
            const value=cookie.split('=')[cookie.split('=').length-1];
            if (value==='MIGRATION'){
                document.querySelector('#migrationBody .nav.nav-tabs .nav-item:first-of-type .nav-link').click();
            }
            else{
                document.querySelector('#migrationBody .nav.nav-tabs .nav-item:nth-of-type(2) .nav-link').click();
            }
        }
    })
}
function displayMultiSelector(){
    document.querySelectorAll('.multipleControlMigration').forEach((element)=>{
        element.style.display='flex';
    });

}
function hideMultiSelector(){
    document.querySelectorAll('.multipleControlMigration').forEach((element)=>{
        element.style.display='none';
    });
}
function countSelectedElement(){
    let count=0;
    document.querySelectorAll('.migrationTable:not(.migrationHistoryTable) tbody tr:not(.migrationModuleIndex) td input').forEach((checkbox)=>{
        if (checkbox.checked){
            count++;
        }
    });
    document.querySelectorAll('.migrationSelectedElement').forEach((element)=>{
        element.innerText=count;
    })
    return count;
}
function displaySpinner(){
    let spinner=document.createElement('div');
    spinner.id='spinnerContainer';
    let background=document.createElement('div');
    background.className='background';
    for (let i=0;i<3;i++){
        let element=document.createElement('div');
        element.className='item';
        background.appendChild(element);
    }
    spinner.appendChild(background);
    document.body.appendChild(spinner);
}
function selectTab(event,direction){
    document.querySelectorAll('#migrationBody .nav-link.text-primary').forEach((tab)=>{
        tab.classList.remove('active');
    });
    event.target.classList.add('active');
    if (direction==='M'){
        document.querySelector('.migrationTable:not(.migrationHistoryTable)').style.display='table';
        document.querySelector('.migrationTable.migrationHistoryTable').style.display='none';
        document.cookie='selected=MIGRATION';
    }
    else{
        document.querySelector('.migrationTable.migrationHistoryTable').style.display='table';
        document.querySelector('.migrationTable:not(.migrationHistoryTable)').style.display='none';
        document.cookie='selected=HISTORY';
    }

}
function removeSpinner(){
    document.getElementById('spinnerContainer')!==null?document.getElementById('spinnerContainer').remove():null;
}
function selectAllMigration(){
    document.querySelectorAll('.migrationModuleIndex').forEach((element)=>{
        element.click();
    })
}
function migrateAllMigration(){
    selectAllMigration();
    migrateMultipleFile();
}
function closePopup(e){
    e.target.closest('.overlay-modal').remove();
}
async function displayPopup(modulename,classname,batchnumber){
    let parser=new DOMParser();
    const response=await fetch(window.location.href+`/showpopup/${modulename}/${classname}/${batchnumber}`);
    let view=await response.text();
    view=parser.parseFromString(view,'text/html');
    document.body.appendChild(view.body);

}
async function migrateMultipleFile(){
    displaySpinner();

    const migrationLinks=[];
    document.querySelectorAll('.migrationTable tr:not(.migrationModuleIndex) input[type=checkbox]').forEach((checkbox)=>{
        if (checkbox.checked===true){
            const checkLine=(checkbox.closest('tr'));
            const migrateLink=checkLine.querySelector('a[href*="migrate/"]');
            const tdCreDate=checkLine.querySelector('td:nth-of-type(4)');
            if (migrateLink!==null)
            migrationLinks.push({creationDate:new Date(tdCreDate.innerText).getTime(),link:migrateLink.getAttribute('href')});

        }
    })
    migrationLinks.sort((element,nextElement)=>{
        if (element.creationDate>nextElement.creationDate){
            return 1;
        }
        else if(element.creationDate<nextElement.creationDate){
            return -1
        }
    });
    for (let i=0;i<migrationLinks.length;i++){
        const migration=migrationLinks[i];
        const response=await fetch(migration.link);
        await response.text();

        if (response.url.includes('?error')){
            window.location.href=response.url;
            return;
        }
    }
    return window.location.reload(true);


}
async function removeMultipleFile(){
    const removemigrationLinks=[];
    document.querySelectorAll('.migrationTable input[type=checkbox]').forEach((checkbox)=>{
        if (checkbox.checked===true&&!checkbox.parentElement.parentElement.classList.contains('migrationModuleIndex')){
            const checkLine=(checkbox.closest('tr'));
            const removemigrateLink=checkLine.querySelector('a[href*="remove/"]');
            const tdCreDate=checkLine.querySelector('td:nth-of-type(4)');
            const migrationName=checkLine.querySelector('td:nth-of-type(3)').innerText;
            removemigrationLinks.push({creationDate:new Date(tdCreDate.innerText).getTime(),link:removemigrateLink.getAttribute('href'),name:migrationName});

        }
    })
    removemigrationLinks.sort((element,nextElement)=>{
        if (element.creationDate>nextElement.creationDate){
            return -1;
        }
        else if(element.creationDate<nextElement.creationDate){
            return 1
        }
    });
    if (removemigrationLinks.length!==0&&await displayWarnings(removemigrationLinks[0].link,removemigrationLinks)) {
        displaySpinner();

        for (let i = 0; i < removemigrationLinks.length; i++) {
            const migration = removemigrationLinks[i];
            const response = await fetch(migration.link+'/2');
            await response.text();

            if (response.url.includes('?error')) {
                return window.location.href = response.url;
            }
        }
        return window.location.reload(true);
    }
    return window.location.reload(true);

}
async function displayWarnings(deleteMigrationLink,migrationNames){
   return new Promise(async (resolve,reject)=>{

       const response=await fetch(deleteMigrationLink);
       const pageTxt=await response.text();
       const page=(new DOMParser()).parseFromString(pageTxt,"text/html");
       document.querySelector('#migrationBody').replaceChildren(page.querySelector('.container:not(#login-bar)'));
       document.querySelector('.container:not(#login-bar) h1').innerText=document.querySelector('.container:not(#login-bar) h1').innerText.split(' ')[0]
       migrationNames.forEach((element,index)=>{
           document.querySelector('.container:not(#login-bar) h1').innerText=document.querySelector('.container:not(#login-bar) h1').innerText+` "${element.name}"`
       });
       document.querySelector('#migrationBody .btn-danger').classList.add('text-white');
       document.querySelector('#migrationBody .btn-danger').style.cursor='pointer';
       document.querySelector('#migrationBody .btn-danger').removeAttribute('href');
       document.querySelector('#migrationBody .btn-danger').addEventListener('click',()=>{
           resolve(true);
       });
       document.querySelector('#migrationBody .btn-default').addEventListener('click',()=>{
           resolve(false);
       })
   })

}
