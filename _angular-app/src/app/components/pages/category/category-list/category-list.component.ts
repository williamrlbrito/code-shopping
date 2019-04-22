import { Component, OnInit, ViewChild } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { CategoryNewModalComponent } from '../category-new-modal/category-new-modal.component';

@Component({
  selector: 'app-category-list',
  templateUrl: './category-list.component.html',
  styleUrls: ['./category-list.component.css']
})
export class CategoryListComponent implements OnInit {

  categories = [];

  @ViewChild(CategoryNewModalComponent)
  categoryNewModal: CategoryNewModalComponent;

  constructor(private http: HttpClient) {

  }

  ngOnInit() {
    this.getCategories();
  }

  getCategories() {
    const token = window.localStorage.getItem('token');
    this.http.get<any>('http://localhost:8000/api/categories', { headers: { 'Authorization': `Bearer ${token}` } })
      .subscribe((response) => {
        this.categories = response.data;
      });
  }

  showModalInsert() {
    this.categoryNewModal.showModal();
  }
}
