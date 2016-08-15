#!/usr/bin/env python
import os,time
import os.path
print "Starting Apache..."
os.system("service apache restart")
absolute_path=""
code_dir=absolute_path+"code/"
app_dir=absolute_path+"app/"
time_count=0

print "Starting Loop..."
while 1:
	for parent,dirnames,filenames in os.walk(code_dir):
		for filename in filenames:
			if filename[-3:]=="php":
				continue
			command_line="/usr/local/bin/fbc -x %s %s"%(app_dir+filename[:-4],code_dir+filename)
			print command_line
			os.system(command_line)
			if os.path.exists(code_dir+filename):
				print "remove "+filename
				os.remove(code_dir+filename)
	time.sleep(0.5)
	time_count+=1
	print "Loop "+str(time_count)+" finsished!"
	if time_count>=144000:
		time.count=0
		os.system("rm error/*.txt timeup/*.txt")
		print "Clear Log Finished!"
