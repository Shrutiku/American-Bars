var InfiniteList = (function () {
  var pub = {};

  var offset = 0;
  var limit = 4; /* enough elements to activate the scrollbar*/
  var serviceEndpoint = null;
  var displayFunction = null;

  /* simulate a webservice */
  function getFakeData(offset, limit, callback) {
    var data = [];
    var i;
    var id;
    for (i = 0; i < limit; i++) {
      id = offset + i;
      data.push({
        id: id,
        name: "Name " + id,
        description: "Description " + id
      });
    }
    setTimeout(function () {
      callback(null, data);
    }, 1000); /* simulate 1s delay for the service call */
  }

  /* real Http service */
  function getRealData(offset, limit, callback, serviceEndpoint) {
      if($('#beerval').val()==0 || offset==0)
    {
    var err = {};
    $.ajax({
      'url' : base_url,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 4
      },
      'success' : function (data) {
      	
      		if(data=='No')
      	{
      		
      		$('#infinite-list').append("<li class='mart10'>No beers added yet.</li>");
      		$('#beerval').val(1);
      		return false;
      	}
      	else{
      		$('#infinite-list').append(data);
      	}
         //$('#infinite-list').append(data);
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
function getRealData_cocktail(offset, limit, callback, serviceEndpoint) {
   if($('#cocktailval').val()==0 || offset==0)
    {
    var err = {};
    $.ajax({
      'url' : base_url_cocktail,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 5
      },
      'success' : function (data) {
      		if(data=='No')
      	{
      		
      		$('#infinite-list-cocktail').append("<li class='mart10'>No cocktails added yet.</li>");
      		$('#cocktailval').val(1);
      		return false;
      	}
      	else{
      		 $('#infinite-list-cocktail').append(data);
      	}
        
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
  
  function getRealData_liquor(offset, limit, callback, serviceEndpoint) {
   if($('#liquorval').val()==0 || offset==0)
    {
    var err = {};
    $.ajax({
      'url' : base_url_liquor,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 5
      },
      'success' : function (data) {
      	if(data=='No')
      	{
      		
      		$('#infinite-list-liquor').append("<li class='mart10'>No liquors added yet.</li>");
      		$('#liquorval').val(1);
      		return false;
      	}
      	else{
      		 $('#infinite-list-liquor').append(data);
      	}
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
  
  function getRealData_comment(offset, limit, callback, serviceEndpoint) {
  
    var err = {};
    $.ajax({
      'url' : base_url_comment,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 4
      },
      'success' : function (data) {
         $('#infinite-list-comment').append(data);
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
  }
  
   function getRealData_favorite_bar(offset, limit, callback, serviceEndpoint) {
  
    var err = {};
    if($('#barval').val()==0 || offset==0)
    {
    $.ajax({
      'url' : base_url_favorite_bar,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 4
      },
      'success' : function (data) {
      	if(data=='No')
      	{
      		$('#infinite-favorite-bar').append("<li class='mart10'>No favorite bars selected yet.</li>");
      		$('#barval').val(1);
      		return false;
      	}
      	else{
      		$('#infinite-favorite-bar').append(data);
      	}
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
  
  
   function getRealData_favorite_beer(offset, limit, callback, serviceEndpoint) {
  
    var err = {};
    if($('#beerval').val()==0 || offset==0)
    {
    $.ajax({
      'url' : base_url_favorite_beer,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 4
      },
      'success' : function (data) {
      	if(data=='No')
      	{
      		$('#infinite-favorite-beer').append("<li class='mart10'>No favorite beers selected yet.</li>");
      		$('#beerval').val(1);
      		return false;
      	}
      	else{
      		$('#infinite-favorite-beer').append(data);
      	}
        
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
  
  function getRealData_favorite_cocktail(offset, limit, callback, serviceEndpoint) {
  
   
    var err = {};
    
   
    if($('#cocktailval').val()==0 || offset==0)
    {
    $.ajax({
      'url' : base_url_favorite_cocktail,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 4
      },
      'success' : function (data) {
      	if(data=='No')
      	{
      		$('#infinite-favorite-cocktail').append("<li class='mart10'>No favorite cocktails selected yet.</li>");
      		$('#cocktailval').val(1);
      		return false;
      	}
      	else{
      		$('#infinite-favorite-cocktail').append(data);
      	}
         
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
   function getRealData_favorite_liquor(offset, limit, callback, serviceEndpoint) {
  
    var err = {};
    
    if($('#liquorval').val()==0 || offset==0)
    {
    $.ajax({
      'url' : base_url_favorite_liquor,
      'type' : 'GET',
      'data' : {
        'offset' : offset,
        'limit' : 4
      },
      'success' : function (data) {
      		if(data=='No')
      	{
      		$('#infinite-favorite-liquor').append("<li class='mart10'>No favorite liquors selected yet.</li>");
      		$('#liquorval').val(1);
      		return false;
      	}
      	else{
      		$('#infinite-favorite-liquor').append(data);
      	}
        
      },
      'error' : function (data, status, error) {
        err.push(status);
        err.push(error);
        callback(err, data);
      }
    });
    }
  }
  /* loop over the data and display it inside the page*/
  function display(err, datas) {
    if (err) {
      console.log('Something went wrong', err);
    } else {
    	$('#infinite-list').append(datas);
      // $.each(datas, function (i, data) {
        // $.each(data, function (key, val) {
          // $('#infinite-list').append('<span>' + key + ': ' + val + '</span><br>');
        // });
        // $('#infinite-list').append('<hr>');
      // });
    }
  }

  function loadData(o, l) {
  	
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData(o, l, displayFunction);
      } else {
        getRealData(o, l, displayFunction, serviceEndpoint);
      }
    }
  }
  
   function loadData_cocktail(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_cocktail(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData_cocktail(o, l, displayFunction);
      } else {
        getRealData_cocktail(o, l, displayFunction, serviceEndpoint);
      }
    }
  }
  
  function loadData_liquor(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_liquor(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData_liquor(o, l, displayFunction);
      } else {
        getRealData_liquor(o, l, displayFunction, serviceEndpoint);
      }
    }
  }
  
  function loadData_comment(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_comment(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData_comment(o, l, displayFunction);
      } else {
        getRealData_comment(o, l, displayFunction, serviceEndpoint);
      }
    }
  }

  function loadData_favorite_bar(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_favorite_bar(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData_favorite_bar(o, l, displayFunction);
      } else {
        getRealData_favorite_bar(o, l, displayFunction, serviceEndpoint);
      }
    }
  }
  
    function loadData_favorite_beer(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_favorite_beer(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData_favorite_beer(o, l, displayFunction);
      } else {
        getRealData_favorite_beer(o, l, displayFunction, serviceEndpoint);
      }
    }
  }
  
   function loadData_favorite_cocktail(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_favorite_cocktail(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData_favorite_cocktail(o, l, displayFunction);
      } else {
        getRealData_favorite_cocktail(o, l, displayFunction, serviceEndpoint);
      }
    }
  }
  
   function loadData_favorite_liquor(o, l) {
    if (arguments.length !== 2) {
      console.log('Usage: InfiniteList.loadData_favorite_liquor(offset, length)');
    } else {
      if (serviceEndpoint === 'local') {
        getRealData_favorite_liquor(o, l, displayFunction);
      } else {
        getRealData_favorite_liquor(o, l, displayFunction, serviceEndpoint);
      }
    }
  }
  /* setDisplay()*/
  function setDisplay(d) {
    if (d === null || d === undefined) {
      displayFunction = display;
    } else {
      displayFunction = d;
    }
  }

  /* setService */
  function setService(s) {
    if (s === null || s === undefined) {
      serviceEndpoint = 'local';
    } else {
      serviceEndpoint = s;
    }
  }

  /* when scrolling to the bottom start loading the new stuff */
  $(document).ready(function () {
    $("#infinite-list").scroll(function () {
      var infiniteList = $('#infinite-list');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData(offset+1, limit);
      }
    });
    
    
    
    $("#infinite-list-comment").scroll(function () {
      var infiniteList = $('#infinite-list-comment');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_comment(offset+1, limit);
      }
    });
    
     $("#infinite-list-cocktail").scroll(function () {
      var infiniteList = $('#infinite-list-cocktail');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_cocktail(offset+1, limit);
      }
    });
    
    $("#infinite-list-liquor").scroll(function () {
      var infiniteList = $('#infinite-list-liquor');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_liquor(offset+1, limit);
      }
    });
    
      $("#infinite-favorite-bar").scroll(function () {
      var infiniteList = $('#infinite-favorite-bar');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_favorite_bar(offset+1, limit);
      }
    });
    
      $("#infinite-favorite-beer").scroll(function () {
      var infiniteList = $('#infinite-favorite-beer');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_favorite_beer(offset+1, limit);
      }
    });
    
     $("#infinite-favorite-cocktail").scroll(function () {
      var infiniteList = $('#infinite-favorite-cocktail');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_favorite_cocktail(offset+1, limit);
      }
    });
    
    $("#infinite-favorite-liquor").scroll(function () {
      var infiniteList = $('#infinite-favorite-liquor');
      if (infiniteList.scrollTop() + infiniteList.innerHeight() >= infiniteList.prop('scrollHeight')) {
        offset += limit;
        loadData_favorite_liquor(offset+1, limit);
      }
    });
  });

  /* define public methods for the module */
  pub.setDisplay = setDisplay;
  pub.setService = setService;
  pub.loadData = loadData;
  pub.loadData_cocktail = loadData_cocktail;
  pub.loadData_liquor = loadData_liquor;
  pub.loadData_comment = loadData_comment;
  pub.loadData_favorite_bar = loadData_favorite_bar;
  pub.loadData_favorite_beer = loadData_favorite_beer;
  pub.loadData_favorite_cocktail = loadData_favorite_cocktail;
  pub.loadData_favorite_liquor = loadData_favorite_liquor;
  

  return pub;
}());

