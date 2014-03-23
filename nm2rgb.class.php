<?php
/****
 *  NM2RGB (PHP Class)
 *  Converts wavelength to RGB.
 *  echo NM2RGB::Hex(420); 
 *  // output: 3800FF    
 ******************************/ 
  Class NM2RGB 
  {   
    Private $__ic    = 0;
    Private $__nm    = 0;
    Private $__red   = 0;
    Private $__green = 0;
    Private $__blue  = 0;
    Private $__correct = False;  
    Const rgbp = "%02X%02X%02X";
    Static Function Hex($nm, $icf = True) 
    {
        
        $rgb = New NM2RGB($nm, $icf);
        return (Int)$rgb->getHex();
    }  
    Public Function getHex()
    {
        $rgb = $this->getRGB();
        return sprintf(self::rgbp, $rgb['r'], $rgb['g'], $rgb['b']);
    } 
    Public Function getRGB()
    {
        $this->__rgbCorrect();  
        return Array(
        'r' => $this->__getRed(),
        'g' => $this->__getGreen(),
        'b' => $this->__getBlue());
    }        
    Function __Construct($nm, $correct = False) 
    {
        $this->__nm = (Int)$nm;
        $this->__correct = (Bool)$correct;
        If (($this->__nm >= 380) && ($this->__nm < 440)){
            $this->__setRGB(((440 - $this->__nm) / 90), 0, 1);
        }ElseIf (($this->__nm >= 440) && ($this->__nm < 490)){
            $this->__setRGB((($this->__nm - 440) / 50), 0, 1);
        }ElseIf (($this->__nm >= 490) && ($this->__nm < 510)){
            $this->__setRGB(0, 1, ((510 - $this->__nm) / 20));
        }ElseIf (($this->__nm >= 510) && ($this->__nm < 580)){
            $this->__setRGB((($this->__nm - 510) / 70), 1, 0);
        }ElseIf (($this->__nm >= 580) && ($this->__nm < 645)){
            $this->__setRGB(1, ((645 - $this->__nm) / 65), 0);
        }ElseIf (($this->__nm >= 645) && ($this->__nm < 780)){
            $this->__setRGB(1, 0, 0);
        }
    } 
    Private Function __rgbCorrect()
    {
        If ($this->__correct){
            If (($this->__nm >= 380) && ($this->__nm < 420)){
               $this->__ic = (0.3 + 0.7 * ($this->__nm - 350) / 70);
            }ElseIf (($this->__nm >= 420) && ($this->__nm < 700)){
               $this->__ic = 1;
            }ElseIf (($this->__nm >= 700) && ($this->__nm < 780)){
               $this->__ic = (0.3 + 0.7 * (780 - $this->__nm) / 80);
            }
            $this->__red   = $this->__red * $this->__ic;
            $this->__blue  = $this->__blue * $this->__ic;
            $this->__green = $this->__green * $this->__ic; 
            return True;       
        }
    }       
    Private Function __setRGB($r = 0, $g = 0, $b = 0) 
    { 
        $this->__red   = $r * 255;
        $this->__green = $g * 255;
        $this->__blue  = $b * 255;
    }
    Private Function __getRed()
    {
        return $this->__red;
    }
    Private Function __getGreen()
    {
        return $this->__green;
    }
    Private Function __getBlue()
    {
        return $this->__blue;
    } 
  }
?>
