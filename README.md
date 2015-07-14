# DoctrineMongoTransaction
Transaction management for MongoDB
#Requirement
1. DoctrineMongoDBBundle (http://symfony.com/doc/current/bundles/DoctrineMongoDBBundle/index.html)

#Usage
1. A request from client to server such as a transaction.
2. Only one transaction for a request.
```
Example:
//Controller
try{
		MongoDBTransaction::startTransaction();
		//Do Something
		MongoDBTransaction::commitTransaction();
}catch(\Exception $e){
	MongoDBTransaction::rollbackTransaction();
	//Do Something
}
```
#License
```
The MIT License (MIT)

Copyright (c) 2015 Duy Huynh

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


