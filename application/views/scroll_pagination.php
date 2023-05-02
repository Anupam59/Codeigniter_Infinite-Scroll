<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $result->post_title; ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">



	<style>
		@-webkit-keyframes placeHolderShimmer {
			0% {
				background-position: -468px 0;
			}
			100% {
				background-position: 468px 0;
			}
		}

		@keyframes placeHolderShimmer {
			0% {
				background-position: -468px 0;
			}
			100% {
				background-position: 468px 0;
			}
		}

		.content-placeholder {
			display: inline-block;
			-webkit-animation-duration: 1s;
			animation-duration: 1s;
			-webkit-animation-fill-mode: forwards;
			animation-fill-mode: forwards;
			-webkit-animation-iteration-count: infinite;
			animation-iteration-count: infinite;
			-webkit-animation-name: placeHolderShimmer;
			animation-name: placeHolderShimmer;
			-webkit-animation-timing-function: linear;
			animation-timing-function: linear;
			background: #f6f7f8;
			background: -webkit-gradient(linear, left top, right top, color-stop(8%, #eeeeee), color-stop(18%, #dddddd), color-stop(33%, #eeeeee));
			background: -webkit-linear-gradient(left, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
			background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
			-webkit-background-size: 800px 104px;
			background-size: 800px 104px;
			height: inherit;
			position: relative;
		}

		.post_data
		{
			padding:24px;
			border:1px solid #f9f9f9;
			border-radius: 5px;
			margin-bottom: 24px;
			box-shadow: 10px 10px 5px #eeeeee;
		}
	</style>



</head>
<body>


<div class="container">
	<h2 align="center"><u>Infinite Scroll Pagination in Codeigniter using Ajax</u></h2>
	<br />

	<p class="d-none" id="currentId"><?= $result->id; ?></p>
	<div id="load_data">
		<div class="post_data test">
			<h3 class="text-danger"><?= $result->post_title; ?></h3>
			<p><?= $result->post_description; ?></p>
		</div>
	</div>

	<div class="d-none" id="load_data"></div>
	<div class="d-none" id="load_data_message"></div>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
</div>







<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    $(document).ready(function(){

        var currentId = $('#currentId').html();
        var limit = 1;
        var start = 0;
        // var action = 'inactive';
        var action = 'inactive';

        function lazzy_loader(limit)
        {
            var output = '';
            for(var count=0; count<limit+1; count++)
            {
                output += '<div class="post_data">';
                output += '<p><span class="content-placeholder" style="width:100%; height: 30px;">&nbsp;</span></p>';
                output += '<p><span class="content-placeholder" style="width:100%; height: 100px;">&nbsp;</span></p>';
                output += '</div>';
            }
            $('#load_data_message').html(output);
        }
        lazzy_loader(limit);


        $("#action").click(function(){
            alert("The paragraph was clicked.");
        });

        // function load_data(limit, start) {
        //     axios.post('http://localhost:8000/ScrollPaginationController/fetch', {
		//     'limit': limit,
		//     'start': start
		//     })
        //         .then(function (response) {
        //             if (response.data == '') {
        //                 $('#load_data_message').html('<h3>No More Result Found</h3>');
        //                 action = 'active';
        //                 alert("No more data");
        //             } else {
        //                 $('#load_data').append(response.data);
        //                 $('#load_data_message').html("");
        //                 action = 'inactive';
        //                 alert(" more data Add");
        //             }
        //         }).catch(function (error) {
        //         alert(" Somthink wrong");
        //     });
        // }



        function load_data(limit, start, currentId)
        {
            var numItems = '';
            $.ajax({
                url:"http://localhost:8000/ScrollPaginationController/fetch",
                method:"POST",
                data:{limit:limit, start:start, currentId:currentId},
                cache: false,
                success:function(data)
                {
                    if(data == '')
                    {
                        $('#load_data_message').html('<h3>No More Result Found</h3>');
                        action = 'active';
                    }
                    else
                    {
                        $('#load_data').append(data);
                        $('#load_data_message').html("");
                        action = 'inactive';

                        numItems = $('.test').length;
                        alert(numItems);
                    }
                }
            })
        }

            // if(action == 'inactive') {
            //     action = 'active';
            //     load_data(limit, start, currentId);
            // }


        $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
            {
                $("#load_data").removeClass("d-none");
                $("#load_data_message").removeClass("d-none");

                lazzy_loader(limit);
                action = 'active';
                start = start + limit;
                setTimeout(function(){
                    load_data(limit, start, currentId);
                });
            }
        });


    });
</script>


</body>
</html>
