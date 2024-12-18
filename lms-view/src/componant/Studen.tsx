import '../assets/sidebar.css';
import {useState} from 'react';
const Student = () => {
  const [close, setClose] = useState(false)
  const [openSub, setOpenSub] = useState(false)
  interface DropdownStates {
  [key: string]: boolean;
}
    const [dropdownStates, setDropdownStates] = useState<DropdownStates>({
      dropdown1: false,
      dropdown2: false,
      // Add more dropdowns as needed
    });
    const handleDropdownToggle = (dropdown: string) => {
      setDropdownStates((prevStates: { [x: string]: any; }) => {
        const newStates: DropdownStates = {};
        Object.keys(prevStates).forEach((key) => {
          newStates[key] = key === dropdown ? !prevStates[key] : false;
        });
        return newStates;
      });
    };
  return (
    <>
        <div className="header"></div>
        
        <div className={`sidebar ${close ? "close" : ""}`}>
          <div className="upperside">
            <i className="fa-solid fa-bars btnToggle" onClick={() => setClose(!close)}></i>
            <div style={{marginTop:"30px"}}>
              <img src="https://fakeimg.pl/80x80/ff0000,128/000,255" />
              <h4 className="studentName">اسم الطالب <i className="fa-regular fa-pen-to-square"></i></h4>
              <span className="upperSpans">Class : KG1</span>
              <span className="upperSpans">ID : 5556665555</span>
              <i className="fa-regular fa-star rate"></i><i className="fa-regular fa-star rate"></i><i className="fa-regular fa-star rate"></i>
            </div>
          </div>
          <ul>
            <li>
            <i className="fa-solid fa-house"></i>
              <a>الصفحة الرئيسية</a>
            </li>
            <li>
            <i className="fa-solid fa-globe"></i>
              <a>تفريغ الوسائط المتعددة</a>
            </li>
            <li onClick={() => handleDropdownToggle('dropdown1')}>
            <i className="fa-solid fa-bars"></i>
              <span>المهام</span>
              {dropdownStates.dropdown1 && 
              <ul className="submenu">
                <li><a>- مهارة اليوم</a></li>
                <li><a>- مهارة الأمس</a></li>
                <li><a>- مهارة المستقبل</a></li>
              </ul>}
            </li>
            <li>
            <i className="fa-solid fa-calendar"></i>
            <a>الجلسات الافتراضية</a></li>

            <li onClick={() => handleDropdownToggle('dropdown2')}>
            <i className="fa-solid fa-bars"></i>
              <span>المهام</span>
              {dropdownStates.dropdown2 && 
              <ul className="submenu">
                <li><a>- مهارة اليوم</a></li>
                <li><a>- مهارة الأمس</a></li>
                <li><a>- مهارة المستقبل</a></li>
              </ul>}
            </li>
          </ul>
        </div>
    </>
   );
};

export default Student;
