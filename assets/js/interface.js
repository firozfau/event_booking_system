// request for sorting data 
function serarchData(searchKewoard){
    tableDataSorting(searchKewoard);
}

// request action 
function actionRequest(requestType)
{
    
    if(requestType=="insert")
    {
       actionInsertRequest(requestType);
    }
    else{
        
        if(showDeleteConfirmationModal())
        {
            actionDeleteRequest(requestType);
            
        }    
    }
    
}