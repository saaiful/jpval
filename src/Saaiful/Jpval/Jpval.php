<?php namespace Saaiful\Jpval;
use Controller;
use View;
use Request;
use Model;
use Session;
use Input;
use Validator;

class Jpval
{
	private $path = '';
	private $rules = [];
	private $jsRules = [];
	private $formClass = [];


	public function init($class)
	{
		$this -> formClass = $class;
		echo '<input type="hidden" name="_validator_path" value="'.Request::path().'">';
	}


	public function set($name,$rules)
	{
		$this->path = Request::path();
		$this->rules[$name] = $rules;
		Session::remove('JPVal');
		Session::put('JPVal', [$this->path => $this->rules]);
		$this->jsRules[$name] = $this->jsRule(explode('|',$rules));
		echo 'id="'.$name.'" name="'.$name.'"';
	}

	public function validate()
	{
		$input = Input::all();
		$data = Session::get('JPVal');
		// var_dump($data);
		// var_dump($input['_validator_path']);
		if(array_key_exists($input['_validator_path'], $data))
		{
			return Validator::make($input, $data[$input['_validator_path']]);
		}
		else
		{
			return true;
		}
	}

	private function renderArray($array)
	{
		foreach ($array as $key => $value) 
		{
			$x = '';
			if(is_array($value))
			{
				$p = $rs = '';
				foreach ($value as $dx => $val) 
				{
					$dr = (!is_integer($dx))? "$dx:" : "";
					if(is_array($val))
					{ 
						$p[$dx] ="\t\t".$dr." [".implode(", ",$this->renderArray($val))."]"; 
					}
					else
					{ 
						if(is_bool($val))
						{
							$val = ($val)? 'true' : 'false';
							$p[$dx] = "\t\t$dr $val";
						}
						else
						{
							$p[$dx] = "\t$dr '$val'";
						}
						
					}
				}
				// var_dump($p);
				if(is_array($p)) { $kr = (!is_integer($key))? "$key:" : ""; $re[]= "\t$kr \n\t{\n".implode(",\n",$p)."\n\t}"; }
				if(is_array($rs)) { $kr = (!is_integer($key))? "$key:" : ""; $re[]= "\t$kr \n\t{\n".implode(",\n",$rs)."\n\t}"; }
				// if(is_array($rs)) { $kr = (!is_integer($key))? "$key:" : ""; $re[]= "$kr \n{\n".implode(",\n",$rs)."\n}"; }
			}
			else
			{
				$key = (is_integer($key)) ? '' : $key.":";
				if($value==true){ $nvalue = "true"; } else { $nvalue = "false"; }
				$re[] = (is_bool($value))?$re[] = "$key $nvalue" : "$key '$value'";
			}
		}
		return $re;
	}

	public function jsRule($arr)
	{
		if(count($arr)==1){ return [$arr[0] => true]; }
		else
		{
			foreach ($arr as $key => $value) 
			{
				if(preg_match("/size:([0-9,]+)/", $value, $match))
				{
					$match = explode(",", $match[1]);
					if(count($match)<2){ $match[1] = $match[0]; }
					$x['rangelength'] = [ $match[0], $match[1] ];
				}
				elseif(preg_match("/between:([0-9,]+)/", $value, $match))
				{
					$match = explode(",", $match[1]);
					if(count($match)<2){ $match[2] = $match[1]; }
					$x['range'] = [ $match[1], $match[2] ];
				}
				elseif(preg_match("/(ma[a-z]+|mi[a-z]+):([0-9]+)/", $value, $match))
				{
					$x[$match[1]] = [ $match[2] ];
				}
				else
				{
					$x[$value] = true;
				}
				
			}
			return $x;
		}
	}

	public function js()
	{
		$rules = implode(",\n",$this->renderArray($this->jsRules));
		$js = View::make('jpval::js')->with('rules' , $rules)->with('class' , $this -> formClass);
		echo "\n".$js."\n";
	}

	public function arrayDecode($arr,$re='')
	{
		// var_dump($re);
		foreach ($arr as $key => $value) 
		{
			$re .= $key ." : ";
			// var_dump($re);
			if(is_array($value))
			{
				// $re .= "{";
				return $this->arrayDecode($value,$re);
			}
			else
			{

				// var_dump($re);
				$re .= "'$value'";
			}
			$xx[] = $re;
			
		}
		// var_dump($re);
		return implode(",", $xx) ;
	}
}
