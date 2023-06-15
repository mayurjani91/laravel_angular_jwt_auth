import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { Router } from '@angular/router';
import { DatashareService } from 'src/app/Services/datashare.service';
import { JarwisService } from 'src/app/Services/jarwis.service';

@Component({
  selector: 'app-blogs',
  templateUrl: './blogs.component.html',
  styleUrls: ['./blogs.component.css']
})
export class BlogsComponent implements OnInit {
blogList = [];
  constructor(private jarwis:JarwisService, public router:Router) {

  }
  ngOnInit(): void {


   //function to return list of numbers from 0 to n-1
  //  numSequence(n: number): Array<number> {
  //   return Array(n);

 this.allBlogs();
  }

allBlogs(){
    this.jarwis.allBlogs().subscribe((res:any) =>{
      // console.log(res.data);
      this.blogList = res.data;
    })
  }

  likeMe(id: string | null)
  {
    this.jarwis.likeMe(id).subscribe((res:any) =>{
    this.allBlogs();
    })
  }

}


