<div id="evm-video-gallery"></div>
<style>
#evm-video-gallery {width: 100%; display: table;text-align: center; margin:30px 0;}
.modal-btn-small {padding: .75em 1em;font-size: 0.8em;}
.modal-box {display: none;position: fixed;z-index: 1000;top:46%!important;}
.modal-btn img {max-width:100%; width:100%; height:auto;}
@media (min-width: 32em) {

.modal-box {
    width: 700px;
    margin: 0 auto!important;
    max-width: 96%;
    padding: 0!important;
}
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position:fixed;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4) !important;
}

.modal-box a.close {
    line-height: 1;
    font-size: 30px;
    position:relative;
    top: -5%;
    right:0;
    text-decoration: none;
    color: #ccc;
    border: none;
    cursor: pointer;
    font-family: "open";
	float:right;
}

.modal-box a.close:hover {
color: #f2f2f2;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
.circle{
    
	position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    background: rgba(0,0,0,0.6);	
	
}
.circle_inner{
    position: relative;
    height: 100%;
	background:url("https://www.apps.expertvillagemedia.com/shopify/evm-gallery/images/videows.png") no-repeat center/30px;
}
  .modal-box > iframe {
    min-height: 394px;
    width: 100%;
}
  .page-container {transform:none!important;}
  @media only screen and (max-width: 750px)
{
.evm-box {width:48%!important;}
  .page-container {transform:none!important;}
}
 @media only screen and (max-width: 667px)
{
.evm-box {width:45%!important;}
  .page-container {transform:none!important;}
  .modal-box > iframe {min-height:245px;}
  #evm-video-gallery {margin:30px 18px;}
}
 @media only screen and (max-width: 480px)
{
.modal-box > iframe {
    min-height: 179px;}
	 #evm-video-gallery {margin:30px 0px;}
	}
 @media only screen and (max-width: 375px)
{
.modal-box > iframe {
    min-height: 394px; }
	 #evm-video-gallery {margin:30px 0px;} }	
	
	
</style>
