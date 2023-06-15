import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { JarwisService } from 'src/app/Services/jarwis.service';

@Component({
  selector: 'app-myblogs',
  templateUrl: './myblogs.component.html',
  styleUrls: ['./myblogs.component.css']
})
export class MyblogsComponent implements OnInit {
  blogList = [];
  imageName: any
  form = {
    id:"",
    title: "",
    description: "",
    image: ""
  }
  Title:string = "Add Blogs";

  constructor(private jarwis: JarwisService, private router: Router) {
    this.myBlogs();
  }


  ngOnInit(): void {


    //function to return list of numbers from 0 to n-1
    //  numSequence(n: number): Array<number> {
    //   return Array(n);

  }

  clearFrom()
  {
        // clear form and preview
        this.form = {id: "", title: "", description: "", image: ""}
        this.imgURL = "";
      this.Title = "Add Blogs";

  }

  myBlogs() {
    this.jarwis.myBlogs().subscribe((res: any) => {
      // console.log(res.data);
      this.blogList = res.data;
    })
  }

  imgURL = ""
  // image preview
  onFileSelected(e: any) {
    if (e.target.files) {
      var reader = new FileReader();
      this.imageName = e.target.files[0];
      reader.readAsDataURL(this.imageName);
      reader.onload = (event: any) => {
        this.imgURL = event.target.result;
        this.form.image = this.imageName
      }
    }
  }

  public error = null;
  public success = null;

  onSubmit() {
    // console.log(this.form);
    const data = this.setFormData(this.form);

    this.jarwis.addBlog(data).subscribe(

      data => this.handleDataSend(data),
      error => this.handleError(error)
    );

  }

  blogEdit(id: string | null) {
    this.Title = "Edit Blogs";
    this.jarwis.blogEdit(id).subscribe((res: any) => {
      this.form.id = res.data[0].id;
      this.form.title = res.data[0].title;
      this.form.description = res.data[0].description;
      this.form.image = "";
      this.imgURL = res.data[0].image;
      console.log(res.data[0]);
      // this.router.navigateByUrl('/blogDetails');

    })
  }
  onUpdate() {
    // console.log(this.form);
    const data = this.setFormData(this.form);

    this.jarwis.updateBlog(data).subscribe(

      data => this.handleDataSend(data),
      error => this.handleError(error)
    );
  }

  blogDelete(id: string | null) {

    this.jarwis.blogDelete(id).subscribe(

      data => this.handleDataSend(data),
      error => this.handleError(error)
    );
  }


  handleDataSend(data: any): void {
    // clear form and preview
    this.form = {id:"", title: "", description: "", image: ""}
    this.imgURL = "";

    // clear previews
    let element: HTMLElement = document.getElementById('auto_trigger') as HTMLElement;
    element.click();

    // console.log(data);
    this.success = data.data;
    this.myBlogs()
  }

  handleError(error: any) {
    this.error = error.error;
    setTimeout(() => {                           // <<<---using ()=> syntax
      this.error = null;
    }, 3000)
    // alert(this.error);

  }

  setFormData(data: any) {
    var fb = new FormData();
    fb.append('id', data.id);
    fb.append('title', data.title);
    fb.append('description', data.description);
    fb.append('image', data.image);
    return fb;
  }

  likeMe(id: string | null)
  {
    this.jarwis.likeMe(id).subscribe((res:any) =>{
    this.myBlogs();
    })
  }


}
