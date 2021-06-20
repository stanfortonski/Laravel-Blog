@push('scripts')
    <script>
        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
        */

        var disqus_config = function(){
            this.page.url = '{{url()->current()}}';
            this.page.identifier = {{$id}};
        };

        (function(){ // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = '{{env("APP_DISQUS")}}';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <script id="dsq-count-scr" src="//codeiter.disqus.com/count.js" async></script>
@endpush
