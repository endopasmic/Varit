Welcome to Twitter 

<style type="text/css">

h1, h2, h3 {
  font-weight: 300;
}

.container {
  padding: 1em;
}

.timeline {
  position: relative;
  overflow: auto;
}
.timeline:before {
  content: '';
  position: absolute;
  height: 100%;
  width: 5px;
  background: #dddddd;
  left: 0;
}
.timeline h2 {
  background: #dddddd;
  max-width: 6em;
  margin: 0 auto 1em;
  padding: 0.5em;
  text-align: center;
  position: relative;
  clear: both;
}
.timeline ul {
  list-style: none;
  padding: 0 0 0 1em;
  z-index: 1;
}
.timeline li {
  background: #dddddd;
  padding: 1em;
  margin-bottom: 1em;
  position: relative;
}
.timeline li:before {
  content: '';
  width: 0;
  height: 0;
  border-top: 1em solid #dddddd;
  border-left: 1em solid transparent;
  position: absolute;
  left: -1em;
  top: 0;
}
.timeline h3 {
  margin-top: 0;
}
.timeline time {
  font-style: italic;
}

@media screen and (min-width: 40em) {
  .container {
    max-width: 1000px;
    margin: 0 auto;
  }

  .timeline:before {
    left: 50%;
  }
  .timeline ul {
    padding-left: 0;
    max-width: 700px;
    margin: 0 auto;
  }
  .timeline li {
    width: 42%;
  }
  .timeline li:nth-child(even) {
    float: right;
    margin-top: 2em;
  }
  .timeline li:nth-child(odd) {
    float: left;
  }
  .timeline li:nth-child(odd):before {
    border-top: 1em solid #dddddd;
    border-right: 1em solid transparent;
    right: -1em;
    left: auto;
  }
  .timeline li:nth-of-type(2n+1) {
    clear: both;
  }
}

</style>

<div class="container">
  <h1>Responsive HTML Timeline</h1>
  
  <p><em>Inspired by the talented <a href="http://daverupert.com/about.html">Dave Rupert</a>.</em></p>
  
  <div class="timeline">
    <h2>2013</h2>
    
    <ul>
      <li>
        <h3>Quit my Job</h3>
        <p>One day, my boss came up to me and asked, "Are you ready, Joe?" Pretty much decided I wasn't ready.</p>
        <time>August 2013</time>
      </li>
      <li>
        <h3>Started New Job</h3>
        <p>Began work at the Button Factory. This was probably the best time of my life. I had a wife, a dog, and a family.</p>
        <time>July 2013</time>
      </li>
      <li>
        <h3>Changed my name to Joe</h3>
        <p>I was just sick of Josh</p>
        <time>June 2013</time>
      </li>
      <li>
        <h3>Moved to Iowa</h3>
        <p>I moved to <a href="#">Ames, Iowa</a> and settled down into my new life.</p>
        <time>February 2013</time>
      </li>
    </ul>
    
    <h2>2012</h2>
    <ul>
      <li>
        <h3>Graduated College</h3>
        <p>It only took, like, two years.</p>
        <time>December 2012</time>
      </li>
      <li>
        <h3>Graduated Community College</h3>
        <p>Studying Aerospace Engineering.</p>
        <time>May 2012</time>
      </li>
    </ul>
  </div>
</div>