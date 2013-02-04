#yahoo weather
#http://weather.yahooapis.com/forecastrss?w=26198380&u=c

########################################################
#WOEID
#http://developer.yahoo.com/yql/console
#elect * from geo.places where text="guangzhou, CN"
########################################################

rm(list=ls())
path='/root/deploy/weather/images/w/'
setwd(path)
#=====================================================
getWeather<-function (x){
  library(RCurl)
  library(XML)
  
  url<-paste('http://weather.yahooapis.com/forecastrss?w=',x,'&u=c',sep="")
  doc = xmlTreeParse(getURL(url),useInternal = TRUE)
  ans<-getNodeSet(doc, "//item/yweather:forecast[1]")
  low<-as.numeric(sapply(ans, xmlGetAttr, "low"))
  high<-as.numeric(sapply(ans, xmlGetAttr, "high"))
  print(paste(x,'==>',low,high))
  cbind(low,high)
}
filename<-function(date=Sys.time()){
  paste(format(date, "%Y%m%d"),".csv",sep="")
}
loadDate<-function(date){
  print(paste('Date','==>',date))
  city<-read.csv(file="WOEID.csv",header=FALSE,fileEncoding="utf-8", encoding="utf-8")
  names(city)<-c("en","woeid","zh",'prov','long','lat')
  city<-city[-nrow(city),]
  
  wdata<-do.call(rbind, lapply(city$woeid,getWeather))
  w<-cbind(city,wdata)
  write.csv(w,file=filename(date),row.names=FALSE,fileEncoding="utf-8")
}
#=====================================================
getColors<-function(mapdata,prov,temp,breaks){
  f=function(x,y) ifelse(x %in% y,which(y==x),0);
  colIndex=sapply(mapdata$NAME,f,prov);
  arr <- findInterval(temp, breaks)
  return(arr[colIndex])
}

weather<-function(data=data,type='high',output=FALSE,path=''){
  library(maps)
  library(mapdata)
  library(maptools)
  map<-readShapePoly('mapdata/bou2_4p.shp')
  
  library("RColorBrewer")
  colors <- c(rev(brewer.pal(9,"Blues")),brewer.pal(9,"YlOrRd"))
  breaks=seq(-36,36,4)
  
  if(type=='high') {
    temp<-data$high
    title<-"中国各省白天气温"
    ofile<-paste(format(date,"%Y%m%d"),"_day.png",sep="")
  }else{
    temp<-data$low 
    title<-"中国各省夜间气温"
    ofile<-paste(format(date,"%Y%m%d"),"_night.png",sep="")
  }
  
  if(output)png(file=paste(path,ofile,sep=''),width=600,height=600)
  layout(matrix(data=c(1,2),nrow=1,ncol=2),widths=c(8,1),heights=c(1,2))
  par(mar=c(0,0,3,10),oma=c(0.2,0.2,0.2,0.2),mex=0.3)
  plot(map,border="white",col=colors[getColors(map,data$prov,temp,breaks)])
  points(data$long,data$lat,pch=19,col=rgb(0,0,0,0.3),cex=0.8)
  
  #=======================================
  if(FALSE){
    grid()
    axis(1,lwd=0);axis(2,lwd=0);axis(3,lwd=0);axis(4,lwd=0)
  }
  text(100,58, title,cex=2)
  text(105,54,format(date,"%Y-%m-%d"))
  
  #=======================================
  for(row in 1:nrow(data)){
    name<-as.character(data$zh[row])
    x1<-ceiling(row/7)
    x2<-ifelse(row%%7==0,7,row%%7)
    x3<-temp[row]
    fontCol<-ifelse(x3<=0,head(colors,1),'#000000')
    text(68+x1*11,17-x2*3,bquote(paste(.(name),.(x3),degree,C)),col=fontCol)
  }
  
  #=======================================
  breaks2 <- breaks[-length(breaks)]
  par(mar = c(5, 0, 15, 10))
  image(x=1, y=0:length(breaks2),z=t(matrix(breaks2)),col=colors[1:length(breaks)-1],axes=FALSE,breaks=breaks,xlab="",ylab="",xaxt="n")
  axis(4, at = 0:(length(breaks2)), labels = breaks, col = "white", las = 1)
  abline(h = c(1:length(breaks2)), col = "white", lwd = 2, xpd = FALSE)
  
  if(output)dev.off()
}

date=Sys.time()
loadDate(date)

#date<-as.Date('20130202',format='%Y%m%d')
data<-read.csv(file=filename(date),header=TRUE,fileEncoding="utf-8", encoding="utf-8")

weather(data,type='high',output=TRUE,path=path)
weather(data,type='low',output=TRUE,path=path)
