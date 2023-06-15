import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { DatashareService } from 'src/app/Services/datashare.service';
import { JarwisService } from 'src/app/Services/jarwis.service';

@Component({
  selector: 'app-blog-details',
  templateUrl: './blog-details.component.html',
  styleUrls: ['./blog-details.component.css']
})
export class BlogDetailsComponent implements OnInit {
  blogDetail = [];

  constructor(private jarwis: JarwisService, public dService: DatashareService, private route: ActivatedRoute, private router: Router) {
    // this.blogDetail = this.dService.blogDetail;
    // console.log(this.blogDetail);

  }
  ngOnInit() {
    this.route.paramMap.subscribe(params => {
      var id = params.get('id');
      console.log(id);

      this.blogDetails(id)
    });


  }
  blogDetails(id: string | null) {
    this.jarwis.blogDetails(id).subscribe((res: any) => {
      this.blogDetail = res.data;
      // console.log(res.data);
      // this.router.navigateByUrl('/blogDetails');

    })
  }
}


